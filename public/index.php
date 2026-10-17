<?php
require __DIR__ . '/../backend/bootstrap.php';

const PROJECTS_PER_PAGE = 8;

$filters = [
    's'    => mb_substr(trim((string) Request::input('s', '')), 0, 100),
    'iddp' => (int) Request::int('iddp'),
    'date' => (string) Request::input('date', ''),
];
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $filters['date'])) {
    $filters['date'] = '';
}

// แสดงเฉพาะโครงการที่อัปโหลดแม่แบบ (เผยแพร่) แล้ว
$conditions = ["p.tempate <> ''"];
$params = [];
if ($filters['s'] !== '') {
    $conditions[] = 'p.name LIKE ?';
    $params[] = '%' . addcslashes($filters['s'], '%_\\') . '%';
}
if ($filters['iddp'] > 0) {
    $conditions[] = 'p.iddp = ?';
    $params[] = $filters['iddp'];
}
if ($filters['date'] !== '') {
    $conditions[] = 'p.date = ?';
    $params[] = $filters['date'];
}
$where = implode(' AND ', $conditions);

$total = (int) Database::value("SELECT COUNT(*) FROM project p WHERE $where", $params);
$totalPages = max(1, (int) ceil($total / PROJECTS_PER_PAGE));
$currentPage = min($totalPages, max(1, (int) Request::int('p')));

$projects = Database::fetchAll(
    sprintf(
        'SELECT p.id, p.name, p.date, p.preview, d.name AS dp_name
         FROM project p LEFT JOIN dp d ON d.id = p.iddp
         WHERE %s ORDER BY p.id DESC LIMIT %d OFFSET %d',
        $where,
        PROJECTS_PER_PAGE,
        ($currentPage - 1) * PROJECTS_PER_PAGE
    ),
    $params
);

View::page('home', [
    'page'        => ['active' => 'home'],
    'filters'     => $filters,
    'projects'    => $projects,
    'departments' => Department::all(),
    'currentPage' => $currentPage,
    'totalPages'  => $totalPages,
    'isFiltered'  => $filters['s'] !== '' || $filters['iddp'] > 0 || $filters['date'] !== '',
    'pageUrl'     => function ($pageNumber) use ($filters) {
        return 'index.php?' . http_build_query(array_filter($filters) + ['p' => $pageNumber]);
    },
]);

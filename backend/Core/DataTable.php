<?php

/**
 * ประมวลผล DataTables แบบ server-side (ค้นหา/เรียง/แบ่งหน้า) ด้วย prepared statement
 *
 * ตัวอย่าง:
 *   DataTable::respond([
 *       'select' => 'p.id, p.name',
 *       'from'   => 'project p',
 *       'where'  => 'p.iddp = ?',          // ไม่บังคับ
 *       'params' => [$departmentId],       // ไม่บังคับ
 *       'search' => ['p.name'],            // คอลัมน์ที่ค้นหาได้
 *       'order'  => [0 => 'p.id', 1 => 'p.name'], // index คอลัมน์ในตาราง => คอลัมน์ SQL
 *       'row'    => function (array $row) { return [...]; },
 *   ]);
 */
final class DataTable
{
    const MAX_PAGE_LENGTH = 100;

    public static function respond(array $options)
    {
        $from = $options['from'];
        $baseWhere = isset($options['where']) ? $options['where'] : '1 = 1';
        $baseParams = isset($options['params']) ? $options['params'] : [];

        list($searchWhere, $searchParams) = self::searchClause($options['search']);
        $where = "($baseWhere) AND ($searchWhere)";
        $params = array_merge($baseParams, $searchParams);

        $total = (int) Database::value("SELECT COUNT(*) FROM $from WHERE $baseWhere", $baseParams);
        $filtered = (int) Database::value("SELECT COUNT(*) FROM $from WHERE $where", $params);

        $sql = sprintf(
            'SELECT %s FROM %s WHERE %s ORDER BY %s LIMIT %d OFFSET %d',
            $options['select'],
            $from,
            $where,
            self::orderClause($options['order']),
            self::length(),
            max(0, (int) Request::input('start', 0))
        );
        $rows = array_map($options['row'], Database::fetchAll($sql, $params));

        Response::json([
            'draw'            => (int) Request::input('draw', 0),
            'recordsTotal'    => $total,
            'recordsFiltered' => $filtered,
            'data'            => $rows,
        ]);
    }

    private static function searchClause(array $columns)
    {
        $search = Request::input('search', []);
        $term = is_array($search) && isset($search['value']) ? trim((string) $search['value']) : '';

        if ($term === '' || !$columns) {
            return ['1 = 1', []];
        }

        $like = '%' . addcslashes($term, '%_\\') . '%';
        $conditions = array_map(function ($column) {
            return "$column LIKE ?";
        }, $columns);

        return ['(' . implode(' OR ', $conditions) . ')', array_fill(0, count($columns), $like)];
    }

    /** เรียงได้เฉพาะคอลัมน์ที่อนุญาตไว้ใน $orderable เท่านั้น */
    private static function orderClause(array $orderable)
    {
        $clauses = [];
        $order = Request::input('order', []);

        foreach (is_array($order) ? $order : [] as $item) {
            $index = isset($item['column']) ? (int) $item['column'] : -1;
            if (isset($orderable[$index])) {
                $direction = (isset($item['dir']) && strtolower($item['dir']) === 'desc') ? 'DESC' : 'ASC';
                $clauses[] = $orderable[$index] . ' ' . $direction;
            }
        }
        return $clauses ? implode(', ', $clauses) : reset($orderable) . ' ASC';
    }

    private static function length()
    {
        $length = (int) Request::input('length', 10);
        return ($length < 1 || $length > self::MAX_PAGE_LENGTH) ? self::MAX_PAGE_LENGTH : $length;
    }
}

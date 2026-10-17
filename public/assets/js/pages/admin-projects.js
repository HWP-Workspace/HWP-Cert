$(function () {
    var TABLE = '#projects';
    var MODAL = '#project-modal';
    var API = 'api/projects.php';
    var STATS_REFRESH_MS = 30000;

    App.dataTable(TABLE, {
        url: API + '?action=list',
        widths: ['7%', '5%', '35%', '30%', '15%', '8%'],
        order: [[0, 'desc']]
    });

    $('#add-project').on('click', function () {
        App.openForm(MODAL, {
            title: 'เพิ่มโครงการ/กิจกรรม',
            action: API + '?action=create',
            values: { iddp: App.page.defaultDepartmentId }
        });
    });

    App.onTableAction(TABLE, 'edit', function (id) {
        App.get(API, { action: 'get', id: id }).done(function (response) {
            App.openForm(MODAL, {
                title: 'แก้ไขโครงการ/กิจกรรม',
                action: API + '?action=update',
                values: response.data
            });
        });
    });

    App.onTableAction(TABLE, 'delete', function (id) {
        App.confirmDelete('คุณแน่ใจไหมที่จะลบโครงการ/กิจกรรม ?', 'ระบบจะลบผู้เข้าร่วมในโครงการ/กิจกรรมนี้ทั้งหมด').then(function (confirmed) {
            if (!confirmed) {
                return;
            }
            App.post(API + '?action=delete', { id: id }).done(function (response) {
                App.success(response.message);
                App.reloadTable(TABLE);
                loadStats();
            });
        });
    });

    function loadStats() {
        App.get('api/stats.php', { action: 'counts' }).done(function (stats) {
            $('#stat-projects').text(stats.projects);
            $('#stat-participants').text(stats.participants);
            $('#stat-admins').text(stats.admins);
        });
    }

    loadStats();
    setInterval(loadStats, STATS_REFRESH_MS);
});

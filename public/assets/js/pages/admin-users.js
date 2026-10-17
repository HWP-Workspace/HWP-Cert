$(function () {
    var TABLE = '#admins';
    var MODAL = '#admin-modal';
    var API = 'api/admins.php';

    App.dataTable(TABLE, {
        url: API + '?action=list',
        widths: ['7%', '30%', '15%', '28%', '12%', '8%']
    });

    $('#add-admin').on('click', function () {
        App.openForm(MODAL, { title: 'เพิ่มผู้ดูแลระบบ', action: API + '?action=create' });
    });

    App.onTableAction(TABLE, 'edit', function (id) {
        App.get(API, { action: 'get', id: id }).done(function (response) {
            App.openForm(MODAL, {
                title: 'แก้ไขข้อมูลผู้ดูแลระบบ',
                action: API + '?action=update',
                values: response.data
            });
        });
    });

    App.onTableAction(TABLE, 'delete', function (id) {
        App.confirmDelete('คุณแน่ใจไหมที่จะลบผู้ดูแลระบบ ?', 'หากลบแล้วผู้ใช้งานจะไม่สามารถเข้าสู่ระบบได้').then(function (confirmed) {
            if (!confirmed) {
                return;
            }
            App.post(API + '?action=delete', { id: id }).done(function (response) {
                App.success(response.message);
                App.reloadTable(TABLE);
            });
        });
    });
});

$(function () {
    var TABLE = '#departments';
    var MODAL = '#department-modal';
    var API = 'api/departments.php';

    App.dataTable(TABLE, {
        url: API + '?action=list',
        widths: ['7%', '40%', '25%', '10%', '10%', '8%']
    });

    $('#add-department').on('click', function () {
        App.openForm(MODAL, { title: 'เพิ่มกลุ่ม/งาน', action: API + '?action=create' });
    });

    App.onTableAction(TABLE, 'edit', function (id) {
        App.get(API, { action: 'get', id: id }).done(function (response) {
            App.openForm(MODAL, {
                title: 'แก้ไขข้อมูลกลุ่ม/งาน',
                action: API + '?action=update',
                values: response.data
            });
        });
    });

    App.onTableAction(TABLE, 'delete', function (id) {
        App.confirmDelete('คุณแน่ใจไหมที่จะลบกลุ่ม/งาน ?', 'หากลบแล้วจะไม่สามารถเพิ่มผู้ใช้เข้าสู่กลุ่ม/งานนี้ได้').then(function (confirmed) {
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

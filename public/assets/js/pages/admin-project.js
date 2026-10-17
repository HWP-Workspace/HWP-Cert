$(function () {
    var TABLE = '#participants';
    var MODAL = '#participant-modal';
    var API = 'api/participants.php';
    var projectId = App.page.projectId;

    App.dataTable(TABLE, {
        url: API + '?action=list&project=' + projectId,
        widths: ['7%', '53%', '30%', '10%'],
        order: [[1, 'asc']]
    });

    $('#add-participant').on('click', function () {
        App.openForm(MODAL, {
            title: 'เพิ่มผู้เข้าร่วมโครงการ/กิจกรรม',
            action: API + '?action=create'
        });
    });

    App.onTableAction(TABLE, 'edit', function (id) {
        App.get(API, { action: 'get', id: id }).done(function (response) {
            App.openForm(MODAL, {
                title: 'แก้ไขผู้เข้าร่วมโครงการ/กิจกรรม',
                action: API + '?action=update',
                values: response.data
            });
        });
    });

    App.onTableAction(TABLE, 'delete', function (id) {
        App.confirmDelete('คุณแน่ใจไหมที่จะลบผู้เข้าร่วม ?', 'หากลบแล้วการรันเลขเกียรติบัตรจะไม่ต่อเนื่องกัน').then(function (confirmed) {
            if (!confirmed) {
                return;
            }
            App.post(API + '?action=delete', { id: id }).done(function (response) {
                App.success(response.message);
                App.reloadTable(TABLE);
            });
        });
    });

    $('#delete-all-participants').on('click', function () {
        App.confirmDelete('คุณแน่ใจไหมที่จะลบผู้เข้าร่วมทั้งหมด ?', 'รายชื่อและเลขที่เกียรติบัตรทั้งหมดในโครงการนี้จะถูกลบ').then(function (confirmed) {
            if (!confirmed) {
                return;
            }
            App.post(API + '?action=delete_all', { project: projectId }).done(function (response) {
                App.success(response.message);
                App.reloadTable(TABLE);
            });
        });
    });

    /* ---------- ตั้งค่ารูปแบบเกียรติบัตร ---------- */

    $('#style-color').colorpicker({ format: 'hex' });

    $('.range-wrap').each(function () {
        var range = this.querySelector('.range');
        var bubble = this.querySelector('.bubble');

        function updateBubble() {
            var percent = ((range.value - range.min) * 100) / (range.max - range.min);
            bubble.textContent = range.value;
            // ชดเชยความกว้างของปุ่มเลื่อนให้ bubble อยู่ตรงกลางปุ่ม
            bubble.style.left = 'calc(' + percent + '% + (' + (8 - percent * 0.15) + 'px))';
        }

        range.addEventListener('input', updateBubble);
        updateBubble();
    });
});

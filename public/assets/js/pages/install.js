/**
 * หน้าติดตั้งระบบ: ต้องกด "ตรวจสอบการเชื่อมต่อ" ก่อน จึงจะรู้ว่าเป็นฐานข้อมูลใหม่ (ต้องสร้างผู้ดูแลระบบ)
 * หรือฐานข้อมูลเดิม (อัปเดตอย่างเดียว)
 */
$(function () {
    var $form = $('form[data-ajax]');
    var $setup = $('#setup-section');
    var $submit = $('#install-submit');
    var $databaseInputs = $form.find('[name^="db_"]');

    if (!$('#check-database').length) {
        return; // โหมดอัปเดตอย่างเดียว
    }

    function resetCheck() {
        $setup.hide().find(':input').prop('disabled', true);
        $('#database-new, #database-existing').hide();
        $submit.prop('disabled', true);
    }

    $('#check-database').on('click', function () {
        if (!$form[0].checkValidity()) {
            $form[0].reportValidity();
            return;
        }

        var data = {};
        $databaseInputs.each(function () {
            data[this.name] = this.value;
        });

        var $button = $(this).prop('disabled', true);
        App.post('api/install.php?action=check', data)
            .done(function (response) {
                $('#database-existing').toggle(response.hasAdmin);
                $('#database-new').toggle(!response.hasAdmin);
                $setup.toggle(!response.hasAdmin).find(':input').prop('disabled', response.hasAdmin);
                $submit.prop('disabled', false);
            })
            .always(function () {
                $button.prop('disabled', false);
            });
    });

    // แสดงตัวอย่างตราสัญลักษณ์ที่เลือก
    $('#school-logo').on('change', function () {
        if (this.files && this.files[0]) {
            $('#logo-preview').attr('src', URL.createObjectURL(this.files[0]));
        }
    });

    // แก้ไขข้อมูลฐานข้อมูลแล้วต้องตรวจสอบใหม่
    $databaseInputs.on('input', resetCheck);
    resetCheck();
});

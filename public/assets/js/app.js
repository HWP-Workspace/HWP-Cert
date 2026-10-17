/**
 * JavaScript ส่วนกลางของระบบ
 *  - แนบ CSRF token ไปกับทุก AJAX request
 *  - DataTable ภาษาไทย, การแจ้งเตือน (SweetAlert), ฟอร์มแบบ AJAX, modal สำหรับเพิ่ม/แก้ไข
 */
(function ($, window) {
    'use strict';

    var config = window.APP || {};

    $.ajaxSetup({
        headers: { 'X-CSRF-Token': config.csrfToken }
    });

    var DATATABLE_LANGUAGE = {
        emptyTable: 'ไม่มีข้อมูลในตาราง',
        info: 'แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว',
        infoEmpty: 'แสดง 0 ถึง 0 จาก 0 แถว',
        infoFiltered: '(กรองข้อมูล _MAX_ ทุกแถว)',
        infoThousands: ',',
        lengthMenu: 'แสดง _MENU_ แถว',
        loadingRecords: 'กำลังโหลดข้อมูล...',
        processing: 'กำลังดำเนินการ...',
        search: 'ค้นหา: ',
        zeroRecords: 'ไม่พบข้อมูล',
        paginate: { first: 'หน้าแรก', previous: 'ก่อนหน้า', next: 'ถัดไป', last: 'หน้าสุดท้าย' },
        aria: {
            sortAscending: ': เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก',
            sortDescending: ': เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย'
        }
    };

    var App = {
        page: config.page || {},

        /* ---------- การแจ้งเตือน ---------- */

        success: function (message) {
            return swal('สำเร็จ!', message, {
                icon: 'success',
                buttons: { confirm: { text: 'ตกลง', className: 'btn btn-success' } }
            });
        },

        warning: function (message) {
            return swal('พบข้อผิดพลาด!', message, {
                icon: 'warning',
                buttons: { confirm: { text: 'ตกลง', className: 'btn btn-warning' } }
            });
        },

        error: function (message) {
            return swal('พบข้อผิดพลาด!', message, {
                icon: 'error',
                buttons: { confirm: { text: 'ตกลง', className: 'btn btn-danger' } }
            });
        },

        /** กล่องยืนยันก่อนลบ — resolve เป็น true เมื่อผู้ใช้กดยืนยัน */
        confirmDelete: function (title, text) {
            return swal(title, text, {
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: { text: 'ยกเลิก', visible: true, className: 'btn btn-secondary' },
                    confirm: { text: 'ลบ', className: 'btn btn-danger' }
                }
            });
        },

        /* ---------- AJAX ---------- */

        get: function (url, data) {
            return App.request({ url: url, method: 'GET', data: data });
        },

        post: function (url, data) {
            var options = { url: url, method: 'POST', data: data };
            if (data instanceof FormData) {
                options.processData = false;
                options.contentType = false;
            }
            return App.request(options);
        },

        /** แสดงข้อความ error จากเซิร์ฟเวอร์ให้อัตโนมัติ */
        request: function (options) {
            return $.ajax($.extend({ dataType: 'json' }, options)).fail(function (xhr) {
                var response = xhr.responseJSON || {};
                var message = response.message || 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้ กรุณาลองใหม่';

                if (xhr.status === 401) {
                    App.warning(message).then(function () { window.location.href = 'login.php'; });
                } else if (response.reload) {
                    App.warning(message).then(function () { window.location.reload(); });
                } else {
                    App.warning(message);
                }
            });
        },

        /* ---------- DataTable ---------- */

        /**
         * @param {string} selector
         * @param {object} options { url, widths: ['7%', ...], order: [[0, 'desc']] }
         * คอลัมน์แรกจะแสดงเป็นลำดับที่ (1, 2, 3, ...)
         */
        dataTable: function (selector, options) {
            var table = $(selector).DataTable({
                serverSide: true,
                responsive: true,
                ajax: {
                    url: options.url,
                    error: function (xhr) {
                        App.warning((xhr.responseJSON && xhr.responseJSON.message) || 'โหลดข้อมูลไม่สำเร็จ');
                    }
                },
                language: DATATABLE_LANGUAGE,
                order: options.order || [[0, 'asc']],
                columns: (options.widths || []).map(function (width) { return { width: width }; })
            });

            table.on('draw.dt', function () {
                var start = table.page.info().start;
                table.column(0, { page: 'applied' }).nodes().each(function (cell, i) {
                    cell.innerHTML = start + i + 1;
                });
            });

            return table;
        },

        /** จับคลิกปุ่มในตารางที่สร้างจาก action_button() ฝั่ง PHP */
        onTableAction: function (selector, action, handler) {
            $(selector).on('click', '[data-action="' + action + '"]', function () {
                handler($(this).data('id'));
            });
        },

        /* ---------- ฟอร์ม/Modal ---------- */

        /**
         * เปิด modal ที่มีฟอร์ม (form[data-ajax]) สำหรับเพิ่มหรือแก้ไขข้อมูล
         * @param {string} modal selector ของ modal
         * @param {object} options { title, action, values }
         *   - element ที่มี data-mode="create" หรือ "edit" จะแสดงเฉพาะโหมดนั้น
         */
        openForm: function (modal, options) {
            var $modal = $(modal);
            var $form = $modal.find('form');
            var mode = options.values && options.values.id ? 'edit' : 'create';

            // reset() ไม่ล้างค่า input hidden จึงต้องล้าง id เอง
            $form[0].reset();
            $form.find('[name="id"]').val('');
            $form.attr('action', options.action);
            $modal.find('.modal-title').text(options.title);
            $modal.find('[data-mode]').each(function () {
                var visible = $(this).data('mode') === mode;
                $(this).toggle(visible).find(':input').prop('disabled', !visible);
            });

            $.each(options.values || {}, function (name, value) {
                $form.find('[name="' + name + '"]').val(value);
            });

            $modal.modal('show');
        },

        reloadTable: function (selector) {
            $(selector).DataTable().draw(false);
        }
    };

    /**
     * ส่งฟอร์มที่มี attribute data-ajax ด้วย AJAX
     *   data-success="reload"            โหลดหน้าใหม่
     *   data-success="table:#selector"   รีเฟรช DataTable
     *   data-success="redirect"          ไปยัง URL ที่เซิร์ฟเวอร์ส่งกลับมา (response.redirect)
     */
    $(document).on('submit', 'form[data-ajax]', function (event) {
        event.preventDefault();

        var $form = $(this);
        var $button = $form.find('[type="submit"]').prop('disabled', true);
        var after = String($form.data('success') || '');

        App.post($form.attr('action'), new FormData(this))
            .done(function (response) {
                if (after === 'redirect' && response.redirect) {
                    window.location.href = response.redirect;
                    return;
                }

                $form.closest('.modal').modal('hide');
                App.success(response.message).then(function () {
                    if (after === 'reload') {
                        window.location.reload();
                    } else if (after.indexOf('table:') === 0) {
                        App.reloadTable(after.substring(6));
                    }
                });
            })
            .always(function () {
                $button.prop('disabled', false);
            });
    });

    /* แสดงชื่อไฟล์ที่เลือกใน custom-file input ของ Bootstrap */
    $(document).on('change', '.custom-file-input', function () {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').text(fileName);
    });

    /* ตรวจสอบขนาด/นามสกุลไฟล์ก่อนอัปโหลด: <input type="file" data-max-bytes="..." accept=".jpg,.png"> */
    $(document).on('change', 'input[type="file"][data-max-bytes]', function () {
        var file = this.files && this.files[0];
        if (!file) {
            return;
        }

        var allowed = String($(this).attr('accept') || '').toLowerCase().split(/\s*,\s*/);
        var extension = '.' + file.name.split('.').pop().toLowerCase();
        var message = null;

        if (allowed[0] !== '' && allowed.indexOf(extension) === -1) {
            message = 'กรุณาอัปโหลดไฟล์ ' + allowed.join(', ') + ' เท่านั้น';
        } else if (file.size > Number($(this).data('max-bytes'))) {
            message = 'กรุณาอัปโหลดไฟล์ขนาดไม่เกิน ' + (Number($(this).data('max-bytes')) / 1048576).toFixed(0) + ' MB';
        }

        if (message) {
            App.warning(message);
            $(this).val('').siblings('.custom-file-label').text('เลือกไฟล์');
        }
    });

    /* ข้อความแจ้งเตือนจากหน้าก่อนหน้า (Session::flash) */
    $(function () {
        var flash = config.flash;
        if (flash && App[flash.type]) {
            App[flash.type](flash.message);
        }
    });

    window.App = App;
})(jQuery, window);

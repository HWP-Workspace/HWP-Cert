$(function () {
    App.dataTable('#participants', {
        url: 'api/public.php?action=participants&project=' + App.page.projectId,
        widths: ['5%', '45%', '40%', '10%'],
        order: [[1, 'asc']]
    });
});

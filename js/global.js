$(function() {
    $('.export-table').on('click', function() {

        var exportTableID = $(this).attr('data-export-table-id');
        var table = $('#' + exportTableID);
        var originalTable = table.clone();

        // Remove inactive rows
        $.each(table.find('tbody').find('tr:not(.active)'), function() {
            $(this).remove();
        });

        table.tableExport({type: 'excel', escape:'false'});

        // Apply original table again
        $('#' + exportTableID).html(originalTable.html());

        return false;
    });

    $('.toggle-active-row').on('change', function() {
        $(this).closest('tr').toggleClass('active');
    });
});
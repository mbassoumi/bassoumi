<script>
    $(document).ready(function () {

        var table = $('#{!! $table_id !!}').DataTable({
            serverSide: true,
            processing: true,
            orderCellsTop: true,
            // deferRender: true,
            scrollX: true,
            scrollY: "500px",
            scrollCollapse: true,
            ajax: {
                url: '{!! $table_ajax !!}',
                dataSrc: 'data'
            },
            columns: {!! $table_columns !!}
        });

        $(table.table().container()).on('keyup change', 'thead .column_search', function () {
            table
                .column($(this).parent().index())
                .search(this.value)
                .draw();
        });

        @if($with_popup)
        $('#{!! $table_id !!} tbody').on('click', 'tr', function () {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            var data = $('#{!! $table_id !!}').DataTable().row(this).data();
            $('#popup_entry').load(data.popup_url);
            $("#popup_modal").modal();
        });
        @endif


    });
</script>

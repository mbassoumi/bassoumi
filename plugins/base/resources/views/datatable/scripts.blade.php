<script>
    $(document).ready(function () {

        var table = $('#{!! $table_id !!}').DataTable({
            serverSide: true,
            processing: true,
            orderCellsTop: true,
            searching: false,
            // deferRender: true,
            scrollX: true,
            scrollY: "500px",
            scrollCollapse: true,
            dom: 'Bfrtip',
            // dom: 'T<"clear">lfrtip',
            buttons: [
                'excel',

            ],
            ajax: {
                url: '{!! $table_ajax !!}',
                dataSrc: 'data',
                data: function (data) {

                    $('#{!! $table_id !!} .table-search-bar input, #{!! $table_id !!} .table-search-bar select').each(
                        function (index) {
                            var key = $(this).attr('name');
                            var classes = $(this).attr('class');
                            var value = $("input[name='" + key + "']").val();
                            if (classes.indexOf('daterange') >= 0){
                                value = getDateRangeValueAsArray(value);
                            }
                            data[key] = value;
                        }
                    );

                }
            },
            columns: {!! $table_columns !!}
        });


        $(table.table().container()).on('keyup change', 'thead .datatable-filter', function () {
            table
                .column($(this).parent().index())
                .search(this.value);
        });



        $('.table-search-bar .daterange').on('apply.daterangepicker cancel.daterangepicker', function (e) {
            e.preventDefault();
            console.log('majd2');
            console.log($(this).val());
            table.draw();
        });

        $('.table-search-bar :input, .table-search-bar :selected').on('change', function (e) {
            e.preventDefault();
            table.draw();
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

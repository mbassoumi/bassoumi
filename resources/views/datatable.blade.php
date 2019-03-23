@extends('adminlte::page')

@section('title', 'DataTable')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>datatable</p>
    <table id="example" class="display">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Has Car?</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
        <tr>
            <th>
                <input type="text" class="column_search" placeholder="Search ID"/>
            </th>
            <th>
                <input type="text" class="column_search" placeholder="Search Name"/>
            </th>
            <th>
                <select class="column_search" placeholder="Search Has Car">
                    <option value="">Search for Car</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </th>
            <th>
                <input type="text" class="column_search" placeholder="Search Email"/>
            </th>
            <th>
                {{--<input type="text" class="column_search" placeholder="Created At"/>--}}
                <input type="text" class="column_search" id="created_at" name="daterange" value="weew" />
            </th>
            <th>
                <input type="text" class="column_search" placeholder="Updated At"/>
            </th>
        </tr>
        </thead>
    </table>


    <style>
        td.highlight {
            background-color: whitesmoke !important;
        }
    </style>
@stop



@section('js')
    <script>

        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ){
                // var min = parseInt( $('#min').val(), 10 );
                // var max = parseInt( $('#max').val(), 10 );
                var start = $('#created_at').val();
                var end = $('#created_at').val();
                console.log(start);
                // var end = $('#min').val();
                var date = parseFloat( data['created_at'] ) || 0; // use data for the age column


                console.log(start, end, date);
                console.log(data);
                if ( ( isNaN( start ) && isNaN( end ) ) ||
                    ( start <= data   && data <= end ) )
                {
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function () {

            var start = $('#created_at').val();

            console.log(start);

            var table = $('#example').DataTable({
                serverSide: true,
                processing: true,
                orderCellsTop: true,
                deferRender: true,
                scrollX: true,

                ajax: {
                    url: 'majd',
                    dataSrc: 'data'
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'has_car'},
                    {data: 'email'},
                    {
                        data: {
                            _: "created_at.display",
                            sort: "created_at.timestamp"
                        }
                    },
                    {
                        data: {
                            _: "updated_at.display",
                            sort: "updated_at.timestamp"
                        }
                    },
                ]
            });

            $(table.table().container()).on('keyup change', 'thead .column_search', function () {
                table
                    .column($(this).parent().index())
                    .search(this.value)
                    .draw();
            });

            $('#example tbody')
                .on('mouseenter', 'td', function () {
                    var colIdx = table.cell(this).index().column;
                    $(table.cells().nodes()).removeClass('highlight');
                    $(table.column(colIdx).nodes()).addClass('highlight');
                });

            $('input[name="daterange"]').daterangepicker({
                // autoUpdateInput: true,
                locale: {
                    cancelLabel: 'Clear'
                },
                opens: 'left'
            }, function (start, end, label) {

                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });


            $('#created_at').keyup( function() {
                table.draw();
            } );


        });
    </script>
@stop



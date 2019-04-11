@extends('adminlte::page')

@section('title', 'DataTable')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>datatable</p>
    <div id="test-modal" class="modal">
        <h1>yahoooo</h1>
    </div>
    <table id="example" class="display nowrap" style="width:100%">
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
                <input name="id_search" type="text" class="column_search" placeholder="Search ID"/>
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
                <input type="text" class="daterange" id="created_at" name="daterange" value=""/>
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
        $(document).ready(function () {

            $('#test-modal').modal();

            var table = $('#example').DataTable({
                serverSide: true,
                processing: true,
                orderCellsTop: true,
                // deferRender: true,
                scrollX: true,


                ajax: {
                    url: 'majd',
                    dataSrc: 'data'
                },
                columns: [
                    {data: 'id', name: 'id'},
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


        });
    </script>
@stop



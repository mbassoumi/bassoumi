<div class="container" style="width: 100%">
    <div class="panel panel-default">
{{--        <div class="panel-heading datatable-header">Panel Heading</div>--}}
        <div class="datatable-header"><h4><b>{!! $datatable_name !!}</b></h4></div>
        <div class="panel-body">


            <table id="{!! $table_id !!}" class="{!! $table_classes !!}" style="width:100%; max-height: 500px">
                <thead>
                <tr>
                    @foreach($table_headers as $table_header)
                        <th>{{$table_header}}</th>
                    @endforeach
                </tr>

                @if(!empty($table_filters))
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

                @endif
                </thead>
            </table>

        </div>
    </div>
</div>

@include('base::datatable.scripts')


<style>
    .datatable-header {
        color: #333;
        background-color: #00acd6;
        border-color: #ddd;
        padding: 5px;
        border-bottom: 1px solid transparent;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }
</style>

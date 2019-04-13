<div class="container" style="width: 100%">
    <div class="panel panel-default">
        {{--        <div class="panel-heading datatable-header">Panel Heading</div>--}}
        <div class="datatable-header"><h4><b>{!! $datatable_name !!}</b></h4></div>
        <div class="panel-body">


            <table id="{!! $table_id !!}" class="{!! $table_classes !!}" style="width:100%; max-height: 500px">
                <thead>
                <tr>
                    @foreach($table_headers as $table_header)
                        <th style="{{$table_header['style']??''}}">
                            {{$table_header['title']}}
                        </th>
                    @endforeach
                </tr>

                @if(!empty($table_filters))
                    @include('base::datatable.filters')
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

    .form-filter {
        border-radius: 4px;
    }
</style>

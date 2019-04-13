<tr class="table-search-bar">
    @foreach($table_filters as $filter)
        <th>
            @if($filter['type'] == 'text')
                {!! Form::text("search[{$filter['name']}]",
                        $filter['value'],
                        [
                            'class'=>'form-control form-filter datatable-filter input-sm',
                            'placeholder' => "{$filter['placeholder']}",
                            'style' => 'width:100%'])
                        !!}
            @elseif($filter['type'] == 'number')
                {!! Form::number("search[{$filter['name']}]",
                            $filter['value'],
                            [
                                'class'=>'form-control form-filter datatable-filter input-sm',
                                'placeholder' => "{$filter['placeholder']}",
                                'style' => 'width:100%'])
                            !!}
            @elseif($filter['type'] == 'date')
                {!! Form::date("search[{$filter['name']}]",
                            $filter['value'],
                            [
                                'class'=>'form-control form-filter datatable-filter input-sm',
                                'placeholder' => "{$filter['placeholder']}",
                                'style' => 'width:100%'])
                            !!}
            @elseif($filter['type'] == 'daterange')
                {!! Form::text("search[{$filter['name']}]",
                        $filter['value'],
                        [
                            'class'=>'form-control form-filter datatable-filter input-sm daterange',
                            'placeholder' => "{$filter['placeholder']}",
                            'style' => 'width:100%'])
                        !!}
            @elseif($filter['type'] == 'email')
                {!! Form::text("search[{$filter['name']}]",
                            $filter['value'],
                            [
                                'class'=>'form-control form-filter datatable-filter input-sm',
                                'placeholder' => "{$filter['placeholder']}",
                                'style' => 'width:100%'])
                            !!}
            @elseif($filter['type'] == 'select')
                {!! Form::select("search[{$filter['name']}]",
                            $filter['options'],
                            $filter['selected'],
                            [
                                'class'=>'form-control form-filter datatable-filter input-sm',
                                'placeholder' => "{$filter['placeholder']}",
                                'style' => 'width:100%'])
                            !!}
            @endif
        </th>
    @endforeach
</tr>

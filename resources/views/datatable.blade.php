@extends('adminlte::page')

@section('title', 'DataTable')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

    {!! $datatable !!}
{{--    @include('base::datatable.table', [--}}
{{--        'table_id' => 'example',--}}
{{--        'table_classes' => 'display nowrap',--}}
{{--        'table_headers' => [--}}
{{--            'ID',--}}
{{--            'Name',--}}
{{--            'Has Car?',--}}
{{--            'Email',--}}
{{--            'Created At',--}}
{{--            'Updated At',--}}
{{--        ],--}}
{{--        'filters' => [],--}}
{{--        'table_ajax' => 'majd'--}}
{{--    ])--}}
@stop



@section('js')

@stop




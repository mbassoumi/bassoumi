@extends('adminlte::page')

@section('title', 'DataTable')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')


{{--    {!! Form::open(['class' => 'js-validate-form']) !!}--}}
{{--    {!! Form::text('majd') !!}--}}
{{--    {!! Form::text('id_search', 'fff', ['class'=>'form-control column_search', 'placeholder' => 'Search ID']) !!}--}}
{{--    {!! Form::close() !!}--}}

{{--{!! Form::text('search[id]', 'fff', ['class'=>'form-control input-sm', '','placeholder' => 'Search ID']) !!}--}}
{{--<form>--}}
{{--<input type="text" value="majd">--}}
{{--</form>--}}

        {!! $datatable !!}

@stop



@section('js')

@stop




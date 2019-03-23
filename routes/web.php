<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
//    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/datatable', 'HomeController@datatable')->name('datatable');


Route::get('majd', function (\Illuminate\Http\Request $request){

//    dd($request->all());
    $attributes = $request->all();
    $perPage = $attributes['length'];

//    $query = \Bassoumi\User::query()->paginate($perPage);
//    dd($query->perPage());
    $data = \Bassoumi\Http\Resources\UserResource::collection(\Bassoumi\User::paginate($perPage));
    $total = $data->total();
    $data = $data->toArray($request);
    $datatableResponse['data'] = $data;
    $datatableResponse['recordsTotal'] = $total;
    $datatableResponse['recordsFiltered'] = $total;
//    dd($datatableResponse);
//    dd($datatableResponse['meta']);
//    $datatableResponse['recordsTotal'] = $datatableResponse['meta']['pagination']['total'];
//    $datatableResponse['recordsFiltered'] = $datatableResponse['meta']['pagination']['total'];
    return response()->json($datatableResponse);
    return \Bassoumi\Http\Resources\UserResource::collection(\Bassoumi\User::query()->paginate($perPage));
//    return \Bassoumi\Http\Resources\UserResource::collection(\Bassoumi\User::all());
//    return new \Bassoumi\Http\Resources\UserResource(\Bassoumi\User::all());

});
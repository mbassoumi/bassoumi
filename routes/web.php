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
//    dd($attributes);

//    $query = \Bassoumi\User::query()->paginate($perPage);
//    dd($query->perPage());

    $page = 1;
    $length = $request->get('length', 10);
    $draw = $request->get('draw', 1);

    if($request->has('page')){
        $page = $request->get('page', 1);
    }elseif($request->has('start', 'length')){
        $start = $attributes['start'];
        $length = $attributes['length'];
        $page = intval($start/$length) + 1;
    }

    $query = \Bassoumi\User::query()->paginate($length, '*', "page", $page);
    $data = \Bassoumi\Http\Resources\UserResource::collection($query);
    $total = $query->total();
    $additionalDataForDatatable = [
        'draw' => $draw,
        'recordsTotal' => $total,
        'recordsFiltered' => $total,
    ];
    $data->additional($additionalDataForDatatable);
    return $data;
    $total = $data->total();
    $data = $data->toArray($request);
    $datatableResponse['data'] = $data;

    $datatableResponse['draw'] = $attributes['draw'];
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

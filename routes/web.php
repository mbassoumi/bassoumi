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

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

Route::get('/', function () {
    return redirect('home');
//    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/datatable', 'HomeController@datatable')->name('datatable');


Route::get('majd', function (\Illuminate\Http\Request $request, \Plugins\Base\src\classes\TestDataTable $dataTable) {
//    return $dataTable->filters()[0]['function']();
    return $dataTable->data($request);
    $attributes = $request->all();
    $page = 1;
    $length = $request->get('length', 10);
    $draw = $request->get('draw', 1);

    if ($request->has('page')) {
        $page = $request->get('page', 1);
    } elseif ($request->has('start', 'length')) {
        $start = $attributes['start'];
        $length = $attributes['length'];
        $page = intval($start / $length) + 1;
    }

    $query = \App\User::query()->paginate($length, '*', "page", $page);
    $data = \App\Http\Resources\UserResource::collection($query);
    $total = $query->total();
    $additionalDataForDatatable = [
        'draw' => $draw,
        'recordsTotal' => $total,
        'recordsFiltered' => $total,
    ];
    $data->additional($additionalDataForDatatable);
    return $data;

});

Route::get('popup', function () {
    return view('show');
})->name('majd-dummy-show');


Route::get('a7a', function () {
    $string = "MajdBasemBassoumi";
    preg_match_all('/((?:^|[A-Z])[a-z]+)/', $string, $matches);
    $matches = Arr::flatten($matches);
    $pluginNameParameters = array_keys(array_flip($matches));
    $routeGroup = implode('-', $pluginNameParameters);
    $routeGroup = Str::lower($routeGroup);
    return $routeGroup;
});


Route::get('test', function () {

    $a = [
        [
            'data' => 'id',
            'name' => 'id'
        ],
        [
            'data' => 'name',
        ],
        [
            'data' => 'has_car',
        ],
        [
            'data' => 'email',
        ],
        [
            'data' => [
                '_' => "created_at.display",
                'sort' => "created_at.timestamp"
            ]
        ],
        [
            'data' => [
                '_' => "updated_at.display",
                'sort' => "updated_at.timestamp"
            ]
        ]
    ];

    dd(json_encode($a));
});

Route::get('test-chess', 'HomeController@chess');

<?php


namespace Plugins\Base\src\classes;


use Carbon\Carbon;

class TestDataTable extends BassoumiDataTable
{

    protected $ajaxUrl = 'majd';

    protected $dataTableName = 'Test Data Table';

    protected $popup = true;


    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            [
                'title' => 'ID',
                'style' => [
                    'min-width' => '50px',
                ],

            ],
            [
                'title' => 'Name',
            ],
            [
                'title' => 'Has Car?',
            ],
            [
                'title' => 'Email',
            ],
            [
                'title' => 'Created At',
            ],
            [
                'title' => 'Updated At',
            ],
        ];
    }

    public function columns(): array
    {
        // TODO: Implement columns() method.
        return [
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
    }

    public function filters()
    {
        return [
            [
                'placeholder' => 'Search ID',
                'name' => 'id',
                'type' => 'number',
                'value' => null,
                'function' => function ($query, $name, $value) {
                    return $query->where($name, $value);
                }
            ],
            [
                'placeholder' => 'Search Name',
                'name' => 'name',
                'type' => 'text',
                'value' => null,
                'function' => function ($query, $name, $value) {
                    return $query->where($name, $value);
                }
            ],
            [
                'placeholder' => 'Search Car',
                'name' => 'car',
                'type' => 'select',
                'selected' => null,
                'options' => [
                    'yes',
                    'no'
                ],
                'function' => function ($query, $name, $value) {
                    return $query;//->whereRaw($name, $value);
                }
            ],
            [
                'placeholder' => 'Search Email',
                'name' => 'email',
                'type' => 'email',
                'value' => null,
                'function' => function ($query, $name, $value) {
                    return $query->where($name, $value);
                }
            ],
            [
                'placeholder' => 'Search Created At',
                'name' => 'created_at',
                'type' => 'daterange',
                'value' => null,
                'function' => function ($query, $name, $value) {
                    $dates = explode('-', $value);
                    foreach ($dates as $index => $date){
                        $dates[$index] = Carbon::parse($date);
                    }
                    return $query->whereBetween($name, $dates);
                }
            ],
            [
                'placeholder' => 'Search Updated At',
                'name' => 'updated_at',
                'type' => 'daterange',
                'value' => null,
                'function' => function ($query, $name, $value) {
                    logger('value');
                    logger($value);
                    $dates = explode('-', $value);
                    foreach ($dates as $index => $date){
                        $dates[$index] = Carbon::parse($date);
                    }
                    return $query->whereBetween($name, $dates);
                }
            ],

        ];
    }

    public function query(): array
    {
        // TODO: Implement query() method.
    }
}

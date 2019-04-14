<?php


namespace Plugins\Base\src\classes;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

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
                    'min-width' => '`100px',
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
                'name' => 'name'
            ],
            [
                'data' => 'has_car',
                'name' => 'has_car'
            ],
            [
                'data' => 'email',
                'name' => 'email'
            ],
            [
                'data' => [
                    '_' => "created_at.display",
                    'sort' => "created_at.timestamp"
                ],
                'name' => 'created_at'
            ],
            [
                'data' => [
                    '_' => "updated_at.display",
                    'sort' => "updated_at.timestamp"
                ],
                'name' => 'updated_at'
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
                'operator' => '=',
            ],
            [
                'placeholder' => 'Search Name',
                'name' => 'name',
                'type' => 'text',
                'value' => null,
                'operator' => 'like',
                'function' => function (Builder $query, $name, $value) {
                    return $query->where($name,'like', '%'.$value.'%');
                }
            ],
            [
                'placeholder' => 'Search Car',
                'name' => 'car',
                'type' => 'select',
                'selected' => null,
                'operator' => '=',
                'options' => [
                    'yes',
                    'no'
                ],
                'function' => function (Builder $query, $name, $value) {
                    return $query;//->whereRaw($name, $value);
                }
            ],
            [
                'placeholder' => 'Search Email',
                'name' => 'email',
                'type' => 'email',
                'value' => null,
                'operator' => 'like',
            ],
            [
                'placeholder' => 'Search Created At',
                'name' => 'created_at',
                'type' => 'daterange',
                'value' => null,
                'operator' => 'between',
            ],
            [
                'placeholder' => 'Search Updated At',
                'name' => 'updated_at',
                'type' => 'daterange',
                'operator' => 'between',
                'value' => null,
            ],

        ];
    }

    public function query(): Builder
    {
        // TODO: Implement query() method.

        return User::query();
    }
}

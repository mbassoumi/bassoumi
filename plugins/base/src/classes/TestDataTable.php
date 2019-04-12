<?php


namespace Plugins\Base\src\classes;


class TestDataTable extends BassoumiDataTable
{

    protected $ajaxUrl = 'majd';

    protected $dataTableName = 'Test Data Table';

    protected $popup = true;

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'ID',
            'Name',
            'Has Car?',
            'Email',
            'Created At',
            'Updated At',
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
            1
        ];
    }
}

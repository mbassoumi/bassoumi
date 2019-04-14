<?php


namespace Plugins\Base\src\classes;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Mixed_;

abstract class BassoumiDataTable
{
    protected $dataTableView = 'base::datatable.table';

    protected $ajaxUrl = '';

    protected $dataTableName = 'dummy_name';

    protected $table_classes = 'display nowrap';

    protected $popup = false;


    public function __construct()
    {

    }

    public final function run()
    {

        $headings = $this->getHeaders();

        $columns = json_encode($this->columns());

        $filters = $this->filters();

        $table_id = Str::slug($this->dataTableName) . '-id';


        return view($this->dataTableView, [
            'table_headers' => $headings,
            'table_filters' => $filters,
            'table_columns' => $columns,
            'table_ajax' => $this->ajaxUrl,
            'table_id' => $table_id,
            'table_classes' => $this->table_classes,
            'datatable_name' => $this->dataTableName,
            'with_popup' => $this->popup
        ])->render();

    }

    protected final function getHeaders()
    {
        $headings = $this->headings();
        $headers = [];
        foreach ($headings as $heading) {
            $title = $heading['title'] ?? 'No Title';
            $stylesArr = $heading['style'] ?? [];
            $style = '';
            if (is_array($stylesArr)) {
                foreach ($stylesArr as $key => $value) {
                    $style .= "$key:$value; ";
                }
            }
            $headers[] = [
                'title' => $title,
                'style' => $style,
            ];

        }
        return $headers;
    }

    public final function data(Request $request)
    {
        $attributes = $request->all();
        $searchs = $request->get('search', []);
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

        $query = \App\User::query();
        $filters = $this->filters();
        foreach ($filters as $filter) {
//            dd($filter['function']($query, $filter['name'], $filter['value']));
            if (isset($searchs[$filter['name']]) and !is_null($searchs[$filter['name']]) and isset($filter['function'])){
                $query = $filter['function']($query, $filter['name'], $searchs[$filter['name']]);
            }
        }
        $query = $query->paginate($length, '*', "page", $page);
        $data = \App\Http\Resources\UserResource::collection($query);
        $total = $query->total();
        $additionalDataForDatatable = [
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
        ];
        $data->additional($additionalDataForDatatable);
        return $data;
    }


    abstract public function query(): array;

    abstract public function headings(): array;

    abstract public function columns(): array;

    public function filters()
    {
        return [];
    }


}

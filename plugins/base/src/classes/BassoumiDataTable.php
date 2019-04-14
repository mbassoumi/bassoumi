<?php


namespace Plugins\Base\src\classes;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    abstract public function query(): Builder;

    abstract public function headings(): array;

    abstract public function columns(): array;

    public function filters()
    {
        return [];
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

    private final function getHeaders()
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

        list($order, $searches, $page, $length, $draw) = $this->getDataTableParams($request);
        $query = $this->addDataTableFilters($searches, $this->query());
        $query = $this->addDataTableOrder($order, $query);
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


    private final function addDataTableOrder(array $order, Builder $query)
    {
        return $query->orderBy($order['name'], $order['dir']);
    }

    private final function getDataTableParams(Request $request)
    {
        $attributes = $request->all();
        $searches = $request->get('search', []);
        $dataTablecolumns = $request->get('columns', []);
        $dataTableOrder = $request->get('order', []);
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

        $order = [
            'name' => $dataTablecolumns[$dataTableOrder[0]['column']]['name'],
            'dir' => $dataTableOrder[0]['dir']
        ];

        return [$order, $searches, $page, $length, $draw];
    }

    private final function addDataTableFilters(array $searches, Builder $query)
    {
        $filters = $this->filters();

        foreach ($filters as $filter) {
            if (isset($searches[$filter['name']]) and !is_null($searches[$filter['name']])) {
                $query = $this->getFilterQuery($filter, $query, $searches);
            }
        }
        return $query;
    }

    public function getFilterQuery(array $filter, Builder $query, array $searches)
    {
        if (isset($filter['function'])) {
            $query = $this->filtersWithFunction($filter, $query, $searches);
        } elseif (isset($filter['operator'])) {
            $query = $this->filtersWithOperator($filter, $query, $searches);
        }
        return $query;
    }

    private final function filtersWithOperator(array $filter, Builder $query, array $searches)
    {
        switch ($filter['operator']) {
            case 'like':
                $query->where($filter['name'], 'like', '%' . $searches[$filter['name']] . '%');
                break;
            case '=':
                $value = $searches[$filter['name']];
                if (in_array($filter['type'], ['date', 'daterange'])) {
                    $value = $value ? Carbon::parse($value)->format('Y-m-d') : null;
                }
                $query->where($filter['name'], '=', $value);
                break;
            case 'between':
                $from = $searches[$filter['name']]['from'] ?? null;
                $to = $searches[$filter['name']]['to'] ?? null;
                if (in_array($filter['type'], ['date', 'daterange'])) {
                    $from = $from ? date($from) : null;
                    $to = $to ? date($to) : null;
                    $filter['name'] = DB::raw("DATE({$filter['name']})");
                }
                if ($from and $to) {
                    $query->whereBetween($filter['name'], [$from, $to]);
                } elseif ($from) {
                    $query->whereDate($filter['name'], '>=', $from);
                } elseif ($to) {
                    $query->whereDate($filter['name'], '<=', $to);
                }
                break;
        }

        return $query;
    }

    private final function filtersWithFunction(array $filter, Builder $query, array $searches)
    {
        return $filter['function']($query, $filter['name'], $searches[$filter['name']]);
    }


}

<?php

namespace App\Http\Controllers;

use App\Http\ChessHelpers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Plugins\Base\src\classes\TestDataTable;

class HomeController extends Controller
{

    use ChessHelpers;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function datatable(TestDataTable $testDataTable)
    {
        $datatable = $testDataTable->run();
//        dd($datatable);
        return view('datatable', ['datatable' => $datatable]);
    }



    public function chess()
    {

//        $set = ['K', 'K', 'R'];
        $set = ['K', 'K','K','K', 'R', 'R'];

//        $height = 3;
//        $width = 3;
        $height = 4;
        $width = 4;
        $length = $height * $width;//count($set);

        $mappingArray = $this->getMappingArray($height, $width);

        $subsets = $this->getSafeSubsets($length, $set, $height, $width, $mappingArray);

        dd($subsets);
        dd(self::$counter);

    }




    static $counter = 0;

}
/*
 * [1 2 1 4]
 * 1st element: 3 rounds  =>  12/4
 * 2nd element: 1 round   =>  (12/4)/3
 * 3ed element: 1 round   =>  ((12/4)/3)/2
 * 4th element: 1 round   =>  (((12/4)/3)/2)/1)
 *
 * nth element:   round   =>  (12/(#elements!/(#elements-n)!)
 *
 * 4 elements {number of array elements}
 * round p
 * first round:
 * thabet first element
 *
 *
 * second round:
 * thabet second element
 *
 *
 * n round:
 * thabet n element
 *
 *
 */

/**
 * [1 2 1 4]
 * 1    2   1   4
 * 1    1   4   2
 * 1    4   1   2
 * 2    1   4   1
 * 2    4   1   1
 * 2    1   1   4
 * 1    4   1   2
 * 1    1   2   4
 * 1    2   4   1
 * 4    1   2   1
 * 4    2   1   1
 * 4    1   1   2
 */

/*
 * repeat = [
 * 0    =>  3
 * 1    =>  1
 * 2    =>  1
 * 3    =>  1
 * ]
 */



<?php

namespace App\Http\Controllers;

use App\Http\ChessHelpers;
use App\Http\ChessValidation;
use App\Http\UnUserd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Plugins\Base\src\classes\TestDataTable;

class HomeController extends Controller
{

    use ChessHelpers, UnUserd, ChessValidation;

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

//        $this->test2();
        $set = ['K', 'K', 'R'];
//        $set = ['K', 'K', 'K', 'K'];
//        $set = ['N', 'N', 'N', 'N', 'R', 'R'];
        $set = ['K', 'K', 'Q', 'Q', 'B', 'B', 'N'];
//        $set = [];
//        for ($i = 0; $i < 8; $i++) {
//            $set[$i] = 'Q';
//        }
//        $height = 8;
//        $width = 8;
        $height = 3;
        $width = 3;
        $height = 5;
        $width = 5;
        $length = $height * $width;

        $mappingArray = $this->getMappingArray($height, $width);
        list($setElements, $setElementsCount) = $this->getSetElementsWithItsCount($set);
//        dd($setElements, $setElementsCount);
        $timeBefore = Carbon::now();
        $subsets = $this->getSafeSubsets($length, $setElements, $setElementsCount, $height, $width, $mappingArray);
        $timeAfter = Carbon::now();
//        $this->printSolution($subsets, $height, $width);
//        dd($subsets);
//        dd(self::$counter);
        $timeDiff = date_diff($timeBefore, $timeAfter);
//        dd($timeDiff);
        dd($timeDiff, $timeDiff->s, $timeDiff->i, $timeDiff->f, self::$counter);


        //when 6x6 => 2m and 26s and 0.44096ms
    }

    public function printSolution($solutions, $height, $width)
    {
        foreach ($solutions as $solution) {
            $temp = '';
            foreach ($solution as $key => $value) {
                if ($key % $width == 0) {
                    $temp .= "\n";
                }
                if ($value == null) {
                    $value = '-';
                }
                $temp .= "$value";

            }
            dump($temp);
        }
    }

    public function getSetElementsWithItsCount($set)
    {
        $setElementsCount = [];
        foreach ($set as $value) {
            if (isset($setElementsCount[$value])) {
                $setElementsCount[$value]++;
            } else {
                $setElementsCount[$value] = 1;
            }
        }
        $setElements = array_keys($setElementsCount);
        return [$setElements, $setElementsCount];
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



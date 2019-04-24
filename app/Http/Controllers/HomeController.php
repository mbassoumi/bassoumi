<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Plugins\Base\src\classes\TestDataTable;

class HomeController extends Controller
{
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
        $set = [1, 2, 3, 4];
        $length = count($set);
        $loopCount = 24 / 1;
        $arr = [];
        $repeat = $this->getRepeat($loopCount, $length);
        $round = 0;
        $startElementIndex = 0;
        for ($i = 0; $i < $loopCount; $i++) {
            if ($round % $repeat[0] == 0 and $round != 0) {
                $round = 0;
                $startElementIndex++;
            }
            $round++;
            $dummyArr = [];
            $dummySubset = $set;
            for ($j = 0; $j < $length; $j++) {
                dump($repeat);
                list($dummyArr[$j], $dummySubset) = $this->getElementAtIndex($round, $j, $repeat, $dummySubset, $startElementIndex);
            }
//            dd($dummyArr);
            $arr[] = $dummyArr;
        }
        dd($arr);
    }

    public function getElementAtIndex($round, $index, $repeat, $subset, $startElementIndex)
    {
        dd($round, $index, $repeat, $subset, $startElementIndex);
        $element = 'k';
        if ($index == 0) {
            $element = $subset[$startElementIndex];
            unset($subset[$startElementIndex]);
            return [$element, $subset];
        } else if ($repeat[$index] == 0) {
            $elementIndex = key($subset);
            $element = $subset[$elementIndex];
            unset($subset[$elementIndex]);
            return [$element, $subset];
//            $neededIndex = $subset[]
//            if ($round)
        } else {
            $dummyRound = $round % $repeat[$index];
            if ($dummyRound == 0 ){
                $dummyRound = $repeat[$index];
            }
        }
        return [$element, $subset];
//        dd($round, $index, $repeat, $set, $subset, $startElementIndex);
    }

    public function getRepeat($loopCount, $length)
    {
        $repeat = [];
        $repeat[] = $loopCount / $length;
        for ($i = 1; $i < $length; $i++) {
            $repeat[$i] = intval($repeat[$i - 1] / ($length - $i));
        }
        return $repeat;
    }

}

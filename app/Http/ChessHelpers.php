<?php


namespace App\Http;


trait ChessHelpers
{


    public function getMappingArray($height, $width)
    {
        $index = 0;
        $mappingArray = [];
        $mappingStraightforwardArray = [];
        $mappingReverseArray = [];
        for ($i = 0; $i < $height; $i++) {
            for ($j = 0; $j < $width; $j++) {
                $mappingStraightforwardArray[$index] = [
                    'key' => "$i-$j",
                    'value' => [
                        'i' => $i,
                        'j' => $j,
                    ]
                ];
                $mappingReverseArray["$i-$j"] = $index;
                $index++;
            }
        }
        $mappingArray = [
            'reverse' => $mappingReverseArray,
            'straightforward' => $mappingStraightforwardArray,
        ];
        return $mappingArray;
    }







    public function getSafeSubsets($length, $set, $height, $width, $mappingArray, $subset = [], $results = [], $firstElement = true)
    {
        $piece = array_shift($set);

        for ($i = 0; $i < $length; $i++) {
            if ($firstElement) {
                $subset = $this->resetSubset($length);
            }
            $previousSubset = $subset;
            if ($this->isSafePiece($subset, $i, $piece, $height, $width, $mappingArray)) {
                $subset[$i] = $piece;
                if (count($set) > 0) {
                    $results = $this->getSafeSubsets($length, $set, $height, $width, $mappingArray, $subset, $results, false);
                } else {
                    $isExist = false;
                    foreach ($results as $result){
                        if ($subset === $result){
                            $isExist = true;
                            break;
                        }
                    }
                    self::$counter++;
                    if (!$isExist){
                        $results[] = $subset;
                    }
                }
            }
            $subset = $previousSubset;
        }
        array_push($set, $piece);
        return $results;
    }

    public function resetSubset($length)
    {
        $subset = [];
        for ($i = 0; $i < $length; $i++) {
            $subset[$i] = '-';
        }
        return $subset;
    }


}



/*
 *
 *
 *
 * public function chess()
    {

        $set = ['K', 'K', 'R'];

        $height = 3;
        $width = 3;
        $length = $height * $width;//count($set);

        $mappingArray = $this->getMappingArray($height, $width);

        $subsets = $this->getSafeSubsets($length, $set, $height, $width, $mappingArray);

        dd(self::$counter);

        $loopCount = $this->getLoopCount($set);
//        dd($loopCount);
        $arr = [];
        $repeat = $this->getRepeat($loopCount, $length);
//        dd('a', $repeat);
        $loops = $this->getLoopsArr($repeat, $length);
//        dd($repeat,$loops);
//        $elementsRounds = $this->calculateElementsRoundsPerSubsetNumber($repeat, $loopCount, $length);


//        $timeBefore = time();
//        dd($timeBefore);
        $timeBefore = Carbon::now();
//        dd($loops);
        $subsets = $this->getSubset($loops, 0, $length, $set, []);
//        foreach ($subsets as $key => $subset) {
//            if (
//                $subset[2] == 'K' and $subset[8] == 'K' and $subset[3] == 'R'
//            ) {
//                dd($key);
////                return true;
//            }
//        }
//        dd('a');
//        dd($subsets);
        $timeAfter = Carbon::now();
//        $timeAfter = time();

//        dd($timeAfter-$timeBefore);

        $timeDiff = date_diff($timeBefore, $timeAfter);

        dd($subsets, $timeDiff->m, $timeDiff->s, $timeDiff->f, $timeDiff);
        dd('a');
        for ($i = 0; $i < $loopCount; $i++) {
            $dummyArr = [];
            $dummySubset = $set;
            for ($j = 0; $j < $length; $j++) {
                list($dummyArr[$j], $dummySubset) = $this->getElementAtIndex($i, $j, $repeat, $dummySubset, $length, $loopCount);
            }
            dd('a');
            $arr[] = $dummyArr;
        }
        dd($arr);
    }
 */

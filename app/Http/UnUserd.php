<?php


namespace App\Http;


trait UnUserd
{


    public function subsetSumRecursive($numbers, $arraySize, $level = 1, $i = 0, $addThis = [])
    {
        // If this is the last layer, use a different method to pass the number.
        if ($level == $arraySize) {
            $result = [];
            for (; $i < count($numbers); $i++) {
                $result[] = array_merge($addThis, array($numbers[$i]));
            }
            return $result;
        }

        $result = [];
        $nextLevel = $level + 1;
        for (; $i < count($numbers); $i++) {
            // Add the data given from upper level to current iterated number and pass
            // the new data to a deeper level.
            $newAdd = array_merge($addThis, array($numbers[$i]));
            $temp = $this->subsetSumRecursive($numbers, $arraySize, $nextLevel, $i, $newAdd);
            $result = array_merge($result, $temp);
        }

        return $result;
    }

    public function getLoopCount($set)
    {
        $repeated = [
            'K' => 0,
            'Q' => 0,
            'B' => 0,
            'R' => 0,
            'N' => 0,
            '-' => 0,
        ];
        $loopCount = 1;
        $loopIndex = 1;
        foreach ($set as $key => $value) {
            $repeated[$value]++;
            $loopCount = $loopCount * $loopIndex;
            $loopIndex++;
        }
        foreach ($repeated as $repeatCount) {
            if ($repeatCount > 0) {
                $loopCount = $loopCount / $this->calculateFractal($repeatCount);
            }
        }


        return $loopCount;
        dd($repeated, $loopCount);
    }

//    public function getSubset($loops, $loopIndex, $length, $set = [], $subset = [], $counter = 0, $result = [])
//    {
////        self::$counter++;
//
//        $loopCount = $loops[$loopIndex];
////        dump('test_' . $counter, $loopIndex, $loops[$loopIndex]);
//
//        for ($i = 0; $i < $loopCount; $i++) {
////            $counter++;
//            if ($loopIndex == 0) {
//                $subset = $this->resetSubset($length);
//            }
//
//            $var = array_shift($set);
////            dump($this->isSafePiece($subset, $loopIndex, $var), $subset, $loopIndex, $var);
//            if ($this->isSafePiece($subset, $loopIndex, $var)) {
//
//                $subset[$loopIndex] = $var;
//
////            dump("loop_$loopIndex with i = $i");
//                if ($loopIndex < $length - 1) {
////                    dump($subset);
//                    $result = $this->getSubset($loops, $loopIndex + 1, $length, $set, $subset, $counter, $result);
//                } else {
////                dump($subset);
//                    $result[] = $subset;
////                $result = $subset;
//                    return $result;
////                $result[] = $subset;
//                }
//            }
//
//            array_push($set, $var);
//
////            dump($loopIndex, $set);
//        }
//
//        return $result;
//
//    }


    public function test2()
    {
        $set = ['K', 'K', 'R'];
        for ($i = 3; $i < 9; $i++) {
            $set[$i] = '-';
        }

        $height = 3;
        $width = 3;
        $length = $height * $width;//count($set);
        $loopCount = $this->getLoopCount($set);
//        dd($loopCount);
        $arr = [];
        $repeat = $this->getRepeat($loopCount, $length);
//        dd('a', $repeat);
        $loops = $this->getLoopsArr($repeat, $length);

        $mappingArray = $this->getMappingArray($height, $width);

//        dd($repeat, $loops);

        $subsets = $this->getSubset($loops, 0, $length, $height, $width, $mappingArray, $set);
        dd($subsets);
    }


    public function getSubset($loops, $loopIndex, $length, $height, $width, $mappingArray, $set = [], $subset = [], $result = [])
    {

        $loopCount = $loops[$loopIndex];
        for ($i = 0; $i < $loopCount; $i++) {
            if ($loopIndex == 0) {
                $subset = $this->resetSubset($length);
            }

            $var = array_shift($set);
            if ($this->isSafePiece($subset, $i, $var, $height, $width, $mappingArray)) {

                $subset[$loopIndex] = $var;
                if ($loopIndex < $length - 1) {
                    $result = $this->getSubset($loops, $loopIndex, $length, $height, $width, $mappingArray, $set, $subset, $result);
                } else {
                    $result[] = $subset;
                    return $result;
                }
            }

            array_push($set, $var);
        }

        return $result;

    }

    public function getLoopsArr($repeat, $length)
    {
        $loopArr = [];
        $tempLength = $length;
        for ($i = 0; $i < $length; $i++) {
            $loopArr[$i] = intval($repeat[$i - 1] / $repeat[$i]);
            if ($loopArr[$i] == 0) {
                $loopArr[$i] = 1;
            }
            $tempLength--;
        }
        return $loopArr;
    }

    public function calculateElementsRoundsPerSubsetNumber($repeat, $loopCount, $length)
    {
        $elementsRounds = [];

        for ($i = 0; $i < $loopCount; $i++) {
            $tempArr = [];
            for ($j = 0; $j < $length; $j++) {
                if ($j == 0) {
                    $a = intval($i / $repeat[$j]);
                } else {
                    $a = intval($i % $repeat[$j]);
                }
                dump("subset number = $i    =>      index = $j with repeat = {$repeat[$j]}      =>          element round = $a");
                $tempArr[$j] = intval(($i % $repeat[$j]) / $repeat[$j]);
            }
            dump('________________________________________________________________________________________________________');
            dump('________________________________________________________________________________________________________');
            dump('________________________________________________________________________________________________________');
            $elementsRounds[$i] = $tempArr;
        }
//        dd($elementsRounds);
    }


    public function getRepeat($loopCount, $length)
    {
        $repeat = [];
        $repeat[0] = $loopCount / $length;
        for ($i = 1; $i < $length; $i++) {
            $repeat[$i] = ceil($repeat[$i - 1] / ($length - $i));
            if ($repeat[$i] == 0) {
                $repeat[$i] = 1;
            }
        }
        $repeat[-1] = $loopCount;
        return $repeat;
    }

    public function calculateFractal($number)
    {
        $result = 1;
        while ($number > 1) {
            $result *= $number;
            $number--;
        }
        return $result;
    }

    public function calculateElementsRounds($numberOfAllElements, $numberOfUniqueElements)
    {
        $elementsRounds = [];
        $dummyRoundsNumber = $numberOfUniqueElements;
        for ($i = 0; $i < $numberOfAllElements; $i++) {
            $dummyRoundsNumber = intval($dummyRoundsNumber / ($numberOfAllElements - $i));
            if ($dummyRoundsNumber == 0) {
                $dummyRoundsNumber = 1;
            }
            $elementsRounds[$i] = $dummyRoundsNumber;
        }
        return $elementsRounds;
    }


    public function getElementAtIndex($subsetNumber, $index, $repeat, $dummySubset, $numberOfAllElements, $loopCount)
    {
        $element = 'k';
        $subset = $dummySubset;
        $elementRound = $repeat[$index - 1] / $repeat[$index];
//        dump($subsetNumber);


//        $elementRound = $numberOfAllElements/

        return [$element, $subset];
    }


    public function chess3()
    {
        $set = [1, 2, 1, 4];
//        $set = [];
//        for ($i=0;$i<81; $i++){
//            $set[] = rand(1,5);
//        }
//        dd($set);
//        $set = ['K', 'K','R', 'N'];

        sort($set);
        $permutations = $this->permuteUnique($set);
        dd($permutations);
    }

    function permuteUnique($items, $perms = [], &$return = [])
    {
//        dd($items);
//        dump($return);
        if (empty($items)) {
            $return[] = $perms;
        } else {
//            sort($items);
//            dd('a');
            $prev = false;
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newitems = $items;
//                dd($newitems, $i);
                $tmp = array_splice($newitems, $i, 1)[0];
                if ($tmp != $prev) {
                    $prev = $tmp;
                    $newperms = $perms;
                    array_unshift($newperms, $tmp);
                    dd($newitems, $newperms, $return);
                    $this->permuteUnique($newitems, $newperms, $return);
                }
            }
            return $return;
        }
    }

    public function getSet()
    {
        $set = [
            0 => 4,
            1 => 1,
            2 => 2,
            3 => 2,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 1,
            10 => 4,
            11 => 0,
            12 => 4,
            13 => 5,
            14 => 4,
            15 => 5,
            16 => 0,
            17 => 5,
            18 => 4,
            19 => 0,
            20 => 0,
            21 => 5,
            22 => 1,
            23 => 5,
            24 => 2,
            25 => 2,
            26 => 1,
            27 => 5,
            28 => 1,
            29 => 1,
            30 => 2,
            31 => 1,
            32 => 0,
            33 => 0,
            34 => 3,
            35 => 4,
            36 => 4,
            37 => 5,
            38 => 5,
            39 => 5,
            40 => 5,
            41 => 0,
            42 => 3,
            43 => 4,
            44 => 5,
            45 => 1,
            46 => 1,
            47 => 1,
            48 => 3,

        ];

//        $set = ['k', 'k', 'q', 'q', 'b', 'b', 'n'];
        $set = [0, 0, 1, 1, 2, 2, 3];
        for ($i = 7; $i < 49; $i++) {
            $set[$i] = 4;
        }
        $set = ['K', 'K', 'R'];
        for ($i = 3; $i < 9; $i++) {
            $set[$i] = '-';
        }
        return $set;
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

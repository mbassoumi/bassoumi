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


    public function isSafePiece($subset, $index, $piece, $height, $width, $mappingArray)
    {

        /**
         * mappingArray = [
         *      Straightforward
         *      reverse
         * ]
         */
        if ($subset[$index] == '-') {
            $check = false;
            switch ($piece) {
                case 'K':
                    $check = $this->isKingSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
                case 'R':
                    $check = $this->isRookSafe($subset, $index, $piece, $height, $width, $mappingArray);
//                    dump($check);
                    break;
            }
            if ($check) {

                $testSubset = $subset;
                $testSubset[$index] = $piece;
                $majd = $this->isSubsetSafe($testSubset, $height, $width, $mappingArray);
                return $majd;
            }
            return $check;
        }
        return false;
    }

    public function isSubsetSafe($subset, $height, $width, $mappingArray)
    {
        $check = true;


//        dd($subset);
        foreach ($subset as $index => $piece) {
//            if ($piece == 'R' and  $index == 3){
//                dd($subset);
//            }
            switch ($piece) {
                case 'K':
                    $check = $this->isKingSafe($subset, $index, $piece, $height, $width, $mappingArray);
//                    if ($subset[0] == 'K' and $subset[3] == 'R'){
//                        dump($index, $piece,$check);
//                    }
                    break;
                case 'R':
                    $check = $this->isRookSafe($subset, $index, $piece, $height, $width, $mappingArray);
//                    if ($subset[0] == 'K' and $subset[3] == 'R'){
//                        dump($index, $piece,$check);
//                    }
//                    dd($check);
                    break;
            }
            if ($check == false) {
                return $check;
            }

        }
//        if ($subset[0] == 'K' and $subset[3] == 'R'){
//            dd($check);
//        }
        return $check;
    }

    public function isKingSafe($subset, $index, $piece, $height, $width, $mappingArray)
    {

        $pieceIndex = $mappingArray['straightforward'][$index];
        $pieceIIndex = $pieceIndex['value']['i'];
        $pieceJIndex = $pieceIndex['value']['j'];
        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                $checkedIndex = ($pieceIIndex + $i) . "-" . ($pieceJIndex + $j);
                if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex]) and $subset[$mappingArray['reverse'][$checkedIndex]] != '-') {
//                    dump('$checkedIndex', $checkedIndex);
//                    dump('$mappingArray[\'reverse\'][$checkedIndex]', $mappingArray['reverse'][$checkedIndex]);
//                    dump('$mappingArray[\'reverse\'][$checkedIndex]', $mappingArray['reverse'][$checkedIndex]);
                    return false;
                }
            }
        }

        return true;
    }

    public function isRookSafe($subset, $index, $piece, $height, $width, $mappingArray)
    {


        $pieceIndex = $mappingArray['straightforward'][$index];
        $pieceIIndex = $pieceIndex['value']['i'];
        $pieceJIndex = $pieceIndex['value']['j'];
        for ($j = -$pieceJIndex; $j <= ($width - 1 - $pieceJIndex); $j++) {
            $checkedIndex = "$pieceIIndex-" . ($pieceJIndex + $j);
            if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex]) and $subset[$mappingArray['reverse'][$checkedIndex]] != '-') {
                return false;
            }
        }
        for ($i = -$pieceIIndex; $i <= ($height - 1 - $pieceIIndex); $i++) {
            $checkedIndex = ($pieceIIndex + $i) . "-$pieceJIndex";
//            if ($index == 6 and $piece == 'R' and $subset[0] == 'K' and $subset[2] == 'K'){
//                dump($checkedIndex);
//            }
            if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex]) and $subset[$mappingArray['reverse'][$checkedIndex]] != '-') {
                return false;
            }
        }
//        if ($index == 6 and $piece == 'R' and $subset[0] == 'K' and $subset[2] == 'K'){
//            dd($subset);
//            dd('a');
//        }


        return true;
    }


    public function getSafeSubsets($length, $set, $height, $width, $mappingArray, $subset = [], $result = [], $firstElement = true)
    {
//        dd($length, $set, $subset, $result, $firstElement);

        //set = [k,k,R]
        //set = [k,R]
        $piece = array_shift($set);
        //set = [k,R]
        //set = [R]

        for ($i = 0; $i < $length; $i++) {
            if ($firstElement) {
                $subset = $this->resetSubset($length);
            }
            // subset = [-,-,-,-]
            $previousSubset = $subset;
            //previousSubset = [-,-,-,-]
            if ($this->isSafePiece($subset, $i, $piece, $height, $width, $mappingArray)) {
                $subset[$i] = $piece;
                //subset = [k,-,-]
                if (count($set) > 0) {
                    $result = $this->getSafeSubsets($length, $set, $height, $width, $mappingArray, $subset, $result, false);
                } else {
//                    dd('a');

                    self::$counter++;
//                    dump($subset);

                    $result[] = $subset;
//                    return $subset;
//                    $result[] = $subset;
//                    return $result;
                }
            }
            $subset = $previousSubset;
        }
        array_push($set, $piece);
        return $result;
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

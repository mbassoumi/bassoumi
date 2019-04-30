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


    public function getSafeSubsets($length, $set, $setElementsCount, $height, $width, $mappingArray, $startIndex = 0, $subset = [], $results = [], $firstElement = true)
    {
//        dump($set, $setElementsCount);
        $previousSet = $set;
        $piece = array_shift($set);
        $setElementsCount[$piece]--;
//        dd($previousSet, $set, $setElementsCount);

        for ($i = $startIndex; $i < $length; $i++) {
            if ($firstElement) {
                $subset = $this->resetSubset($length);
            }
            $previousSubset = $subset;
            list($check, $subset) = $this->isSafePiece($subset, $i, $piece, $height, $width, $mappingArray);
            if ($check) {
//                $subset = $this->removeInvalidPositions($subset, $i, $piece);
                $subset[$i] = $piece;
                if ($setElementsCount[$piece] == 0) {
                    $recursionSet = $set;
                    $startIndex = 0;
                } else {
                    $recursionSet = $previousSet;
                    $startIndex = $i + 1;
                }
                if (count($recursionSet) > 0) {

                    $results = $this->getSafeSubsets($length, $recursionSet, $setElementsCount, $height, $width, $mappingArray, $startIndex, $subset, $results, false);
                } else {
                    self::$counter++;
                    $results[] = $subset;
                }
            }
            $subset = $previousSubset;
        }
//        array_push($set, $piece);
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

<?php


namespace App\Http;


trait ChessValidation
{
    public function isSafePiece($subset, $index, $piece, $height, $width, $mappingArray)
    {

        /**
         * mappingArray = [
         *      Straightforward
         *      reverse
         * ]
         */
        if (isset($subset[$index]) and  $subset[$index] == '-') {
            $check = false;
            switch ($piece) {
                case 'K':
                    list($check, $subset) = $this->isKingSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
                case 'R':
                    list($check, $subset) = $this->isRookSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
                case 'N':
                    list($check, $subset) = $this->isKnightSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
                case 'Q':
                    list($check, $subset) = $this->isQueenSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
                case 'B':
                    list($check, $subset) = $this->isBishopSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
            }
//            if ($check) {
//                $testSubset = $subset;
//                $testSubset[$index] = $piece;
//                $majd = $this->isSubsetSafe($testSubset, $height, $width, $mappingArray);
//                return $majd;
//            }
            return [$check, $subset];
        }
        return [false, []];
    }

    public function isSubsetSafe($subset, $height, $width, $mappingArray)
    {
        $check = true;


        foreach ($subset as $index => $piece) {
            switch ($piece) {
                case 'K':
                    $check = $this->isKingSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
                case 'R':
                    $check = $this->isRookSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
                case 'N':
                    $check = $this->isKnightSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
                case 'Q':
                    $check = $this->isQueenSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
                case 'B':
                    $check = $this->isBishopSafe($subset, $index, $piece, $height, $width, $mappingArray);
                    break;
            }
            if ($check == false) {
                return $check;
            }
        }
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
                list($check, $subset) = $this->checkPosition($checkedIndex, $pieceIndex, $mappingArray, $subset);
                if (!$check) {
                    return [false, []];
                }
            }
        }
        return [true, $subset];
    }

    public function isRookSafe($subset, $index, $piece, $height, $width, $mappingArray)
    {


        $pieceIndex = $mappingArray['straightforward'][$index];
        $pieceIIndex = $pieceIndex['value']['i'];
        $pieceJIndex = $pieceIndex['value']['j'];
        for ($j = -$pieceJIndex; $j <= ($width - 1 - $pieceJIndex); $j++) {
            $checkedIndex = "$pieceIIndex-" . ($pieceJIndex + $j);
            list($check, $subset) = $this->checkPosition($checkedIndex, $pieceIndex, $mappingArray, $subset);
            if (!$check) {
                return [false, []];
            }
        }
        for ($i = -$pieceIIndex; $i <= ($height - 1 - $pieceIIndex); $i++) {
            $checkedIndex = ($pieceIIndex + $i) . "-$pieceJIndex";
            list($check, $subset) = $this->checkPosition($checkedIndex, $pieceIndex, $mappingArray, $subset);
            if (!$check) {
                return [false, []];
            }
        }
        return [true, $subset];
    }

    public function isKnightSafe($subset, $index, $piece, $height, $width, $mappingArray)
    {
        $pieceIndex = $mappingArray['straightforward'][$index];
        $pieceIIndex = $pieceIndex['value']['i'];
        $pieceJIndex = $pieceIndex['value']['j'];
        for ($i = -2; $i <= 2; $i++) {
            if ($i == 0) {
                continue;
            }
            $j = 3 - abs($i);
            $checkedIndex = ($pieceIIndex + $i) . "-" . ($pieceJIndex + $j);
            list($check, $subset) = $this->checkPosition($checkedIndex, $pieceIndex, $mappingArray, $subset);
            if (!$check) {
                return [false, []];
            }
            $checkedIndex = ($pieceIIndex + $i) . "-" . ($pieceJIndex - $j);
            list($check, $subset) = $this->checkPosition($checkedIndex, $pieceIndex, $mappingArray, $subset);
            if (!$check) {
                return [false, []];
            }
        }
        return [true, $subset];
    }

    public function isQueenSafe($subset, $index, $piece, $height, $width, $mappingArray)
    {
        $pieceIndex = $mappingArray['straightforward'][$index];
        $pieceIIndex = $pieceIndex['value']['i'];
        $pieceJIndex = $pieceIndex['value']['j'];
        $multiplier = max($height, $width);
        for ($m = 1; $m < $multiplier; $m++) {
            for ($i = -1; $i <= 1; $i++) {
                for ($j = -1; $j <= 1; $j++) {
                    $checkedIndex = ($pieceIIndex + ($m * $i)) . "-" . ($pieceJIndex + ($m * $j));
                    list($check, $subset) = $this->checkPosition($checkedIndex, $pieceIndex, $mappingArray, $subset);
                    if (!$check) {
                        return [false, []];
                    }
                }
            }
        }
        return [true, $subset];
    }

    public function isBishopSafe($subset, $index, $piece, $height, $width, $mappingArray)
    {
        $pieceIndex = $mappingArray['straightforward'][$index];
        $pieceIIndex = $pieceIndex['value']['i'];
        $pieceJIndex = $pieceIndex['value']['j'];
        $multiplier = max($height, $width);

        for ($i = -($multiplier - 1); $i < $multiplier; $i++) {
            $checkedIndex = ($pieceIIndex + $i) . "-" . ($pieceJIndex + $i);
            list($check, $subset) = $this->checkPosition($checkedIndex, $pieceIndex, $mappingArray, $subset);
            if (!$check) {
                return [false, []];
            }
            $checkedIndex = ($pieceIIndex + $i) . "-" . ($pieceJIndex - $i);
            list($check, $subset) = $this->checkPosition($checkedIndex, $pieceIndex, $mappingArray, $subset);
            if (!$check) {
                return [false, []];
            }
        }
        return [true, $subset];
    }

    public function checkPosition($checkedIndex, $pieceIndex, $mappingArray, $subset)
    {
        if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex])) {
            if ($subset[$mappingArray['reverse'][$checkedIndex]] != '-' and $subset[$mappingArray['reverse'][$checkedIndex]] != null) {
                return [false, []];
            } else {
                $subset[$mappingArray['reverse'][$checkedIndex]] = null;
            }
        }
        return [true, $subset];
    }


}

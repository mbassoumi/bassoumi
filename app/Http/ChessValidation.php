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
        if ($subset[$index] == '-') {
            $check = false;
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
                if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex]) and $subset[$mappingArray['reverse'][$checkedIndex]] != '-') {
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
            if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex]) and $subset[$mappingArray['reverse'][$checkedIndex]] != '-') {
                return false;
            }
        }
        return true;
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
            if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex]) and $subset[$mappingArray['reverse'][$checkedIndex]] != '-') {
                return false;
            }
            $checkedIndex = ($pieceIIndex + $i) . "-" . ($pieceJIndex - $j);
            if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex]) and $subset[$mappingArray['reverse'][$checkedIndex]] != '-') {
                return false;
            }
        }
        return true;
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
                    if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex]) and $subset[$mappingArray['reverse'][$checkedIndex]] != '-') {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function isBishopSafe($subset, $index, $piece, $height, $width, $mappingArray)
    {
        $pieceIndex = $mappingArray['straightforward'][$index];
        $pieceIIndex = $pieceIndex['value']['i'];
        $pieceJIndex = $pieceIndex['value']['j'];
        $multiplier = max($height, $width);

        for ($i = -($multiplier - 1); $i < $multiplier; $i++) {
            $checkedIndex = ($pieceIIndex + $i) . "-" . ($pieceJIndex + $i);
            if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex]) and $subset[$mappingArray['reverse'][$checkedIndex]] != '-') {
                return false;
            }
            $checkedIndex = ($pieceIIndex + $i) . "-" . ($pieceJIndex - $i);
            if ($checkedIndex != $pieceIndex['key'] and isset($mappingArray['reverse'][$checkedIndex]) and $subset[$mappingArray['reverse'][$checkedIndex]] != '-') {
                return false;
            }
        }
        return true;
    }


}

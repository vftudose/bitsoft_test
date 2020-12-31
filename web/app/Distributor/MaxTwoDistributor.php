<?php

namespace App\Distributor;

use App\Distributor\Exceptions\TooFewBallsException;
use App\Distributor\Exceptions\TooManyBallsException;

class MaxTwoDistributor implements Distributable
{
    const MAX_RESULTS = 3;

    private ColorTransformer $colorTransformer;

    public function __construct(ColorTransformer $colorTransformer)
    {
        $this->colorTransformer = $colorTransformer;
    }

    /**
     * @param int $totalBoxes
     * @param array $colorDistribution
     * @return array
     * @throws TooFewBallsException
     * @throws TooManyBallsException
     */
    public function distribute(int $totalBoxes, array $colorDistribution): array
    {
        if (array_sum($colorDistribution) > ($totalBoxes * $totalBoxes)) {
            throw new TooManyBallsException('We have too many colored balls!');
        }

        if (array_sum($colorDistribution) < ($totalBoxes * $totalBoxes)) {
            throw new TooFewBallsException('We have too few colored balls!');
        }

        $colorsString = $this->colorTransformer->toString($colorDistribution);

        $results = [];

        $this->searchForDistributions($colorsString, 0, strlen($colorsString), $totalBoxes, $results);

        return $this->colorTransformer->toArray($results[rand(0, count($results) - 1)], $totalBoxes);
    }

    private function searchForDistributions($str, $left, $right, $totalBoxes, &$results)
    {
        if (count($results) > self::MAX_RESULTS) {
            return;
        }

        if ($left == $right &&
            !in_array($str, $results) &&
            !$this->hasMoreThanTwoColors($str, $right, $totalBoxes)
        ) {
            $results[] = $str;
        }

        for ($i = $left; $i < $right; $i++) {
            $this->swapPlaces($str, $left, $i);
            $this->searchForDistributions($str, $left + 1, $right, $totalBoxes, $results);
            $this->swapPlaces($str, $left, $i);
        }
    }

    private function hasMoreThanTwoColors($str, $n, $totalBoxes)
    {
        for ($i = 0; $i < $n; $i += $totalBoxes) {
            $chunk = [];
            for ($j = $i; $j < $totalBoxes + $i; $j++) {
                $chunk[] = $str[$j];
            }

            if (count(array_unique($chunk)) > 2) {
                return true;
            }
        }

        return false;
    }

    private function swapPlaces(&$str, $i, $j)
    {
        $temp = $str[$i];
        $str[$i] = $str[$j];
        $str[$j] = $temp;
    }
}

<?php

namespace App\Distributor;

class ColorTransformer
{
    public function toString(array $colorDistribution): string
    {
        $colorsString = '';

        foreach ($colorDistribution as $color => $count) {
            for ($i = 0; $i < $count; $i++) {
                $colorsString .= Distributable::COLOR_MAP[$color];
            }
        }

        return $colorsString;
    }

    public function toArray(string $colors, $splitBy)
    {
        $colorMap = array_flip(Distributable::COLOR_MAP);

        $chunks = [];
        for ($i = 0; $i < strlen($colors); $i += $splitBy) {
            $chunk = [];
            for ($j = $i; $j < $splitBy + $i; $j++) {
                $chunk[] = $colorMap[$colors[$j]];
            }
            $chunks[] = $chunk;
        }

        return $chunks;
    }
}

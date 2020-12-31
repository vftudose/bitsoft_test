<?php

namespace App\Distributor;

use Exception;

interface Distributable
{
    const RED = 'red';
    const BLUE = 'blue';
    const YELLOW = 'yellow';
    const GREEN = 'green';
    const VIOLET = 'violet';
    const ORANGE = 'orange';
    const PURPLE = 'purple';
    const SALMON = 'salmon';
    const INDIGO = 'indigo';
    const CYAN = 'cyan';

    const COLOR_MAP = [
        self::RED => 'r',
        self::BLUE => 'b',
        self::YELLOW => 'y',
        self::GREEN => 'g',
        self::VIOLET => 'v',
        self::ORANGE => 'o',
        self::PURPLE => 'p',
        self::SALMON => 's',
        self::INDIGO => 'i',
        self::CYAN => 'c',
    ];

    /**
     * @param int $totalBoxes
     * @param array $colorDistribution
     * @return array
     * @throws Exception
     */
    public function distribute(int $totalBoxes, array $colorDistribution): array;
}

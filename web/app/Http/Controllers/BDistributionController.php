<?php

namespace App\Http\Controllers;

use App\Distributor\Distributable;
use App\Models\Distribution;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;

class BDistributionController extends Controller
{
    private Distributable $ballsDistributor;

    public function __construct(Distributable $ballsDistributor)
    {
        $this->ballsDistributor = $ballsDistributor;
    }

    public function show()
    {
        return view('welcome');
    }

    public function groupColors(Request $request)
    {
        $n = $request->get('totalColors');

        $requestedColors = $request->get('colors');

        $colors = [];

        for ($i = 0; $i < $n; $i++) {
            $colors[$requestedColors[$i]['color']] = $requestedColors[$i]['count'];
        }

        try {
            $hash = md5(json_encode($colors));

            $distribution = Distribution::where('hash', '=', $hash)->first();

            if ($distribution) {
                return $distribution->value;
            }

            $distributedBalls = $this->ballsDistributor->distribute($n, $colors);

            $distribution = new Distribution([
                'hash' => $hash,
                'value' => $distributedBalls
            ]);

            $distribution->save();

        } catch (Exception $exception) {
            return new JsonResponse([
                $exception->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        return $distributedBalls;
    }

}

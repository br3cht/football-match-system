<?php

namespace App\Http\Controllers;

use App\DTO\InputSoccer;
use App\UseCases\Soccer\GetCompetions;
use App\UseCases\Soccer\GetMatches;
use App\UseCases\Soccer\GetStadings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $dataCompetions = Cache::get('competions');

        if(empty($dataCompetions)){
            $dataCompetions = $this->getCompetions();
        }
    }

    private function getCompetions()
    {
        $getCompetions = resolve(GetCompetions::class);

        return $getCompetions->execute();
    }

    public function standing(Request $request)
    {
        $input = new InputSoccer(
            idCompetition: 2021,
            filter:[
                'dateFrom' => now()->format('Y-m-d'),
                'dateTo' => now()->format('Y-m-d'),
            ],
            team: null,
        );

        $execute = resolve(GetStadings::class);

        return $execute->execute($input);
    }

    public function matches()
    {
        $data = Cache::get('match_competion:2021:matches');
        $input = new InputSoccer(
            idCompetition: 2021,
            filter:[
                'season' => now()->format('Y')
            ],
            team: null
        );

        $execute = resolve(GetMatches::class);

        if(empty($data)){
            $data = $execute->execute($input);
        }

        return response()->json($data);
    }
}

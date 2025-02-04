<?php

namespace App\UseCases\Soccer;

use App\Services\CacheManager;
use App\Services\FootballDataService;

class SearchTeam
{
    public function __construct(
        private FootballDataService $footballDataService,
        private CacheManager $cacheManager
    ) {}

    public function execute(string $teamName)
    {
        $dataCompetions = $this->cacheManager->get('competion');

        foreach($dataCompetions as $item){
            $teams = $item['teams'];

            return array_filter($teams, function ($team) use ($teamName){
                return $team['name'] == $teamName;
            });
        }

    }
}

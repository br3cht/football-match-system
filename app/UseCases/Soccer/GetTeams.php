<?php

namespace App\UseCases\Soccer;

use App\DTO\InputSoccer;
use App\Integrations\FootballDataIntegration;
use App\Services\CacheManager;
use App\Services\FootballDataService;
use Illuminate\Support\Facades\Cache;

class GetTeams {
    public function __construct(
        protected FootballDataService $footballDataService,
        protected CacheManager $cacheManager
    ) { }

    public function execute(int $idCompetition) {
        $data = $this->footballDataService->getTeamByCompetion($idCompetition);

        if(empty($data)){
            return [];
        }

        $this->cacheManager->put('competition', $idCompetition . ':teams', $data);

        return $data;
    }
}

<?php

namespace App\UseCases\Soccer;

use App\Integrations\FootballDataIntegration;
use App\Services\FootballDataService;
use Illuminate\Support\Facades\Cache;

class GetCompetions {
    public function __construct(
        protected FootballDataService $footballDataService,
    )
    { }

    public function execute() {
        $data = $this->footballDataService->getCompetions();

        if(!empty($data)){
            Cache::put('competions', $data);
        }

        return $data;
    }
}


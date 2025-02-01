<?php

namespace App\UseCases\Soccer;

use App\Integrations\FootballDataIntegration;
use Illuminate\Support\Facades\Cache;

class GetCompetions {
    public function __construct(
        protected FootballDataIntegration $footballDataIntegration
    )
    { }

    public function execute() {
        $data = $this->footballDataIntegration->getCompetions();

        if(!empty($data)){
            Cache::put('competions', $data);
        }

        return $data;
    }
}


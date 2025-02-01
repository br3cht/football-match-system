<?php

namespace App\UseCases\Soccer;

use App\DTO\InputSoccer;
use App\Integrations\FootballDataIntegration;
use Illuminate\Support\Facades\Cache;

class GetStadings {
    public function __construct(
        protected FootballDataIntegration $footballDataIntegration
    ) { }

    public function execute(InputSoccer $input) {
        $data = $this->footballDataIntegration->getStandings($input);

        if(empty($data)){
            return [];
        }
    }
}

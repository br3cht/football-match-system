<?php

namespace App\UseCases\Soccer;

use App\DTO\InputSoccer;
use App\Integrations\FootballDataIntegration;
use App\Services\FootballDataService;
use Illuminate\Support\Facades\Cache;

class GetMatches
{
    public function __construct(
        protected FootballDataService $footballDataService
    ) {}

    public function execute(InputSoccer $input)
    {
        $data = $this->footballDataService->getMatches($input);

        if (empty($data)) {
            return [];
        }

        Cache::put('match_competition:' . $input->idCompetition . ':matches', $data);

        return $data;
    }
}

<?php

namespace App\UseCases\Soccer;

use App\DTO\InputSoccer;
use App\Integrations\FootballDataIntegration;
use Illuminate\Support\Facades\Cache;

class GetMatches
{
    public function __construct(
        protected FootballDataIntegration $footballDataIntegration
    ) {}

    public function execute(InputSoccer $input)
    {
        $data = $this->footballDataIntegration->getMatches($input);

        if (empty($data)) {
            return [];
        }

        Cache::put('match_competion:' . $input->idCompetition . ':matches', $data);

        return $data;
    }

    private function formatDataMatches(array $data)
    {
        $matches = [
            'emblem' => $data['competion']['emblem'],
            'current_season'  => $data['matches'][0]['currentMatchDay'],
        ];

        foreach($data as $item){
        }
    }
}

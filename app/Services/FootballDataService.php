<?php

namespace App\Services;

use App\DTO\InputSoccer;
use App\Integrations\FootballDataIntegration;

class FootballDataService
{
    public function __construct(
        private FootballDataIntegration $footballDataIntegration
    ) {}

    public function getMatches(InputSoccer $input)
    {
        $data = $this->footballDataIntegration->getMatches($input);

        if(empty($data)){
            return $data;
        }

        $data = $this->formatDataMatches($data);

        return $data;
    }

    private function formatDataMatches(array $data): array
    {
        $matches = [
            'emblem' => $data['competion']['emblem'],
            'current_season'  => $data['matches'][0]['currentMatchDay'],
        ];

        foreach($data['matches'] as $item){
            $matches['data'][] = [
                'id' => $item['id'],
                'date' => $item['utcDate'],
                'status' => $item['status'],
                'home_team' => $item['homeTeam']['name'],
                'home_team_logo' => $item['homeTeam']['crest'],
                'home_team_score' => $item['score']['fullTime']['homeTeam'],
                'away_team' => $item['awayTeam']['name'],
                'away_team_logo' => $item['awayTeam']['crest'],
                'away_team_score' => $item['score']['fullTime']['awayTeam'],
                'matchday' => $item['matchday']
            ];
        }

        return $matches;
    }
}

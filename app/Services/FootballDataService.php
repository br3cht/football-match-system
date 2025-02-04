<?php

namespace App\Services;

use App\DTO\InputSoccer;
use App\Integrations\FootballDataIntegration;

class FootballDataService
{
    public function __construct(
        private FootballDataIntegration $footballDataIntegration
    ) {}

    public function getCompetions(): array
    {
        $data = $this->footballDataIntegration->getCompetions();

        return $this->formatDataCompetions($data);
    }

    private function formatDataCompetions(array $data)
    {
        $dataFormated = [];

        foreach($data as $item){
            if(in_array($item['code'], ['PL', 'SA', 'PD', 'FL1', 'BL1', 'DED', 'BSA'])){
                $dataFormated[] =[
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'emblem' => $item['emblem'],
                    'current_matchday' => $item['currentSeason']['currentMatchday']
                ];
            }
        }

        return $dataFormated;
    }

    public function getMatches(InputSoccer $input)
    {
        $data = $this->footballDataIntegration->getMatches($input);

        if(empty($data['matches'])){
            return [];
        }

        $data = $this->formatDataMatches($data);

        return $data;
    }

    private function formatDataMatches(array $data): array
    {
        $matches = [
            'emblem' => $data['competition']['emblem'],
            'current_season'  => $data['matches'][0]['season']['currentMatchday'],
        ];

        foreach($data['matches'] as $item){
            $matches['data'][] = [
                'id' => $item['id'],
                'date' => $item['utcDate'],
                'status' => $item['status'],
                'home_team' => $item['homeTeam']['name'],
                'home_team_logo' => $item['homeTeam']['crest'],
                'home_team_score' => $item['score']['fullTime']['home'],
                'away_team' => $item['awayTeam']['name'],
                'away_team_logo' => $item['awayTeam']['crest'],
                'away_team_score' => $item['score']['fullTime']['away'],
                'matchday' => $item['matchday']
            ];
        }

        return $matches;
    }
}

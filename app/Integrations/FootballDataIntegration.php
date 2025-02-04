<?php

namespace App\Integrations;

use App\DTO\InputSoccer;
use Illuminate\Support\Facades\Http;

class FootballDataIntegration
{

    public function __construct(
        private string $url = "https://api.football-data.org/v4/"
    ) {}

    public function getAreas(): array
    {
        $response = Http::get($this->url . 'areas');

        if ($response->failed()) {
            return [];
        }

        return json_decode($response->json(), true);
    }

    public function getCompetions(): array
    {
        $response = Http::get($this->url . 'competitions');

        if ($response->failed()) {
            return [];
        }

        return $response->json()['competitions'];
    }

    public function getMatches(InputSoccer $inputSoccer): array
    {
        $response = Http::withHeaders(['X-Auth-Token' => config('services.football_data.token')])->get($this->url . 'competitions/' . $inputSoccer->idCompetition . '/matches/');

        return $this->validateResponse($response);
    }

    public function getStandings(InputSoccer $inputSoccer): array
    {
        $param = [
            'dateFrom' => $inputSoccer->filter['dateFrom'],
            'dateTo' => $inputSoccer->filter['dateTo']
        ];

        $response = Http::withHeaders(['X-Auth-Token' => config('services.football_data.token')])->get($this->url . 'competitions/' . $inputSoccer->idCompetition . '/standings/', $param);

        return $this->validateResponse($response);
    }



    private function validateResponse($response): array
    {
        if ($response->failed()) {
            return [];
        }

        return $response->json();
    }
}

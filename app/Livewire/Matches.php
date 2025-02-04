<?php

namespace App\Livewire;

use App\DTO\InputSoccer;
use App\UseCases\Soccer\GetCompetions;
use App\UseCases\Soccer\GetMatches;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Matches extends Component
{
    public $competitions = [];
    public $matches = [];
    public $competitionSelected = 0;
    public $currentRound = 0;
    public $rounds = 0;

    public function mount()
    {
        $dataCompetions = Cache::get('competions');

        if(empty($dataCompetions)){
            $competions = resolve(GetCompetions::class);
            $dataCompetions = $competions->execute();
        }

        $this->competitions = $dataCompetions;
    }

    public function getMatches($idCompetition, $currentSeason)
    {
        $this->currentRound = $currentSeason;
        $this->rounds = $currentSeason;
        $this->competitionSelected = $idCompetition;

        $data = $this->getDataMatch($idCompetition);

        $this->matches = optional($data)['data'] ?? [];
        if(!empty($currentSeason)) {
            $this->filterByRound($currentSeason);
        }
    }

    private function getDataMatch(int $idCompetition): array
    {
        $data = Cache::get('match_competition:' . $idCompetition . ':matches');
        if(empty($data)){
            $input = new InputSoccer(
                idCompetition: $idCompetition,
                filter:null,
                team: null
            );

            $matches = resolve(GetMatches::class);
            $data = $matches->execute($input);
        }

        return $data;
    }

    private function filterByRound($round)
    {
        $this->matches = array_filter($this->matches, function ($match) use ($round) {
            return $match['matchday'] == $round;
        });
    }

    public function showPreviousRound()
    {
        $this->rounds -= 1;
        $data  = $this->getDataMatch($this->competitionSelected);
        $this->matches = $data['data'];
        $this->filterByRound($this->rounds);
    }

    public function showNextRound()
    {
        $this->rounds += 1;
        $data  = $this->getDataMatch($this->competitionSelected);
        $this->matches = $data['data'];
        $this->filterByRound($this->rounds);
    }

    public function render()
    {
        return view('livewire.matches');
    }
}

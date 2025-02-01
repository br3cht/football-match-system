<?php

namespace App\DTO;

class InputSoccer {
    public function __construct(
        public readonly int $idCompetition,
        public readonly array|null $filter,
        public readonly string|null $team
    ){ }
}

<?php

namespace App\UseCases\Soccer;

class GetAreas
{
    public function __construct(

    )
    { }

    public function execute()
    {
        $footballDataIntegration = new \App\Integrations\FootballDataIntegration();

        return $footballDataIntegration->getAreas();
    }
}

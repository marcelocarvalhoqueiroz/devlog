<?php

namespace App\Services;

use App\Models\Tech;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;


class TechService {
    public function getOrCreate(string $name): Tech{
        $tech = Tech::firstOrCreate(
            ['name' => $name],
            ['uuid' => (string) Str::uuid(), 'iconUrl' => ''] 
        );
        return $tech;
    }
}
<?php

namespace App\Services;

use App\Models\Experience;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;


class ExperienceService {
    public function __construct(private TechService $techService){}

    public function create(array $data): Experience {
        $uuid = (string) Str::uuid();
        return DB::transaction(function () use ($data, $uuid) {
            $experience = Experience::create([
                'title' => $data['title'],
                'problem' => $data['problem'],
                'solution' => $data['solution'],
                'learned' => $data['learned'],
                'category' => $data['category'],  
                'product_id' => $data['product_id'],  
                'uuid' => $uuid,
            ]);

            foreach ($data['techs'] ?? [] as $techName) {
                $tech = $this->techService->getOrCreate($techName);
                $experience->experienceTechTechs()->attach($tech->uuid);
            }

            return $experience;
        });
    }

    public function update(array $data, string $id): Experience {
        $experience = Experience::where('uuid', $id)->firstOrFail();
        $experience->update($data);
        return $experience;
    }

    public function findByUuid(string $id): Experience{
        $experience = Experience::where('uuid', $id)->firstOrFail();

        return $experience;
    }

    /**
     * @return Collection<int, Experience>
    */
    public function getExperiences(): Collection {
        $experiences = Experience::get();

        return $experiences;
    }

    public function delete(string $id): void{
        $experience = Experience::where('uuid', $id)->firstOrFail();
        $experience->delete();
    }
}
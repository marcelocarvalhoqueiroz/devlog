<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;


class CompanyService {
    public function create(array $data): Company {
        $uuid = (string) Str::uuid();
        $company = Company::create([
            ...$data,
            'uuid' => $uuid,
        ]);

        return $company;
    }

    public function update(array $data, $id): Company {
        $company = Company::where('uuid', $id)->firstOrFail();
        $company->update($data);
        return $company;
    }

    public function findByUuid(string $id): Company{
        $company = Company::where('uuid', $id)->firstOrFail();

        return $company;
    }

    /**
     * @return Collection<int, Company>
    */
    public function getCompanies(): Collection {
        $companies = Company::get();

        return $companies;
    }

    public function delete(string $id){
        $company = Company::where('uuid', $id)->firstOrFail();
        $company->delete();
    }
}
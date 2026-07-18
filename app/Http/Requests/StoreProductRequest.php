<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class StoreProductRequest extends AuthorizedFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'website' => 'active_url|nullable',
            'git_source' => 'active_url|nullable',
            'description' => 'required|string',
            'company_id' => 'required|exists:companies,uuid'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser uma string válida',
            'website.active_url' => 'O campo website deve ser uma url válida (repositório no git, site, etc)',
            'git_source.active_url' => 'O campo git source deve ser uma url válida (repositório no git, site, etc)',
            'description.required' => 'A descrição é obrigatória',
            'description.string' => 'A descrição deve ser uma string válida',
            'company_id.required' => 'É obrigatório o projeto ser vinculado a uma empresa (Caso seja projeto pessoal, é recomendado criar uma Company que represente você!)',
            'company_id.exists' => 'Deve ser um uuid de empresa válida.'
        ];
    }
}

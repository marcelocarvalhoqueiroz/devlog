<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

class StoreCompanyRequest extends AuthorizedFormRequest
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
            'start_date' => [ 
                'required',
                'date', 
                Rule::date()->before(today()),
                
            ],
            'end_date' => [
                'nullable',
                'date',
                Rule::date()->beforeOrEqual(today())->after('start_date')
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser uma string válida',
            'website.active_url' => 'O campo website deve ser uma url válida (repositório no git, site, etc)',
            'start_date.required' => 'O campo data inicial é obrigatório',
            'start_date.date' => 'O campo data inicial deve ser uma data válida',
            'start_date.before' => 'O campo data inicial deve ser uma data do passado',
            'end_date.date' => 'O campo data final deve ser uma data válida',
            'end_date.before_or_equal' => 'O campo data final deve ser igual ou menor que hoje (ou nullo)',
            'end_date.after' => 'O campo data final deve ser uma data depois da data inicial',
        ];
    }
}

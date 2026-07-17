<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'website' => 'active_url|nullable',
            'git_source' => 'active_url|nullable',
            'description' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O nome deve ser uma string válida',
            'website.active_url' => 'O campo website deve ser uma url válida (repositório no git, site, etc)',
            'git_source.active_url' => 'O campo git source deve ser uma url válida (repositório no git, site, etc)',
            'description.string' => 'A descrição deve ser uma string válida'
        ];
    }
}

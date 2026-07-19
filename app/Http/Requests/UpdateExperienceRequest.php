<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class UpdateExperienceRequest extends AuthorizedFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string',
            'problem' => 'string',
            'solution' => 'string',
            'learned' => 'string',
            'category' => 'string'
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'O título deve ser uma string válida',
            'problem.string' => 'O problema deve ser uma string válida',
            'solution.string' => 'A solução deve ser uma string válida',
            'learned.string' => 'O aprendizado deve ser uma string válida',
            'category.string' => 'A categoria deve ser uma string válida'
        ];
    }
}

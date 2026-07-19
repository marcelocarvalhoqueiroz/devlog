<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class StoreExperienceRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'problem' => 'required|string',
            'solution' => 'required|string',
            'learned' => 'required|string',
            'category' => 'required|string',
            'product_id' => 'required|exists:products,uuid',
            'techs' => 'nullable|array',
            'techs.*' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório',
            'title.string' => 'O título deve ser uma string válida',
            'problem.required' => 'O problema é obrigatório',
            'problem.string' => 'O problema deve ser uma string válida',
            'solution.required' => 'A solução é obrigatória',
            'solution.string' => 'A solução deve ser uma string válida',
            'learned.required' => 'O aprendizado é obrigatório',
            'learned.string' => 'O aprendizado deve ser uma string válida',
            'category.required' => 'A categoria é obrigatória',
            'category.string' => 'A categoria deve ser uma string válida',
            'product_id.required' => 'Vincular um produto é obrigatório',
            'product_id.exists' => 'O id deve ser de um produto existente',
            'techs.array' => 'O campo techs deve ser um Array válido',
            'techs.*.requried' => 'A tech é obrigatória',
            'techs.*.string' => 'A tech deve ser uma string válida'
        ];
    }
}

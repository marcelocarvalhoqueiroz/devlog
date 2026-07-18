<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthorizedFormRequest extends FormRequest
{
    /**
     * Request base para retornar sempre autorizado (como o projeto vai rodar local, é o ideal)
     */
    public function authorize(): bool
    {
        return true;
    }
}

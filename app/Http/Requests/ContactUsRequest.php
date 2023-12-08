<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactUsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        return [
            'full_name'=>'required|string',
            'message'=>'required|string',
            'email' => 'required|email',
            'phone' => ['sometimes', Rule::phone()->country(get_cached_countries()->pluck('code'))->mobile()],
            'phone_country' => ['required_with:phone'],
        ];
    }
}

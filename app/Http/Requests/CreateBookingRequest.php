<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBookingRequest extends FormRequest
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
            'full_name' => 'required|string',

            'day' => 'required|int',
            'month' => 'required|int',
            'year' => 'required|int',
            'date_of_birth' => 'sometimes|date',

            'phone' => ['required', Rule::phone()->mobile()],
            'phone_country' => ['required_with:phone'],

            'country_id' => 'required|exists:countries,id',
            'category_id' => 'required|exists:categories,id',
            'subscription_id' => 'required|exists:subscriptions,id',

            'location_of_course' => 'required|string',
            'days' => ['required', 'array', 'min:1'],

            'notes' => ['nullable', 'sometimes', 'string', 'max:2048'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $date = [];
        array_push($date, $this->input('year'), $this->input('month'), $this->input('day'));
        $concatenatedValue = implode('-', $date);

        $this->merge(['date_of_birth' => $concatenatedValue]);
    }
}

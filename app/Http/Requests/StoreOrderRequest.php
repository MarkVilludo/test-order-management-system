<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'menu_item_id' => 'required|exists:menu_items,id',
            'total_price'  => 'required|numeric',
        ];
    }

    /**
     * Get the custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'menu_item_id.required' => 'Please select a menu item.',
            'menu_item_id.exists'   => 'The selected menu item does not exist.',
            'total_price.required'  => 'The total price is required.',
            'total_price.numeric'   => 'The total price must be a number.',
        ];
    }
}

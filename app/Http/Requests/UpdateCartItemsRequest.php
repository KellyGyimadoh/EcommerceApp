<?php

namespace App\Http\Requests;

use App\Models\Products;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $cartItems = $this->route('cartItems'); // Get the current CartItem instance
        return [
            'product_id'=>['required'],
            'quantity'=>['required',
        'min:1',
        'integer',
        function($attribute,$value,$fail)use($cartItems){
            $product=Products::find($cartItems->product_id);
            if($value > $product->stock_quantity){
                $fail("The quantity cannot exceed the available stock");

            }
        }
        ],

        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrdersRequest extends FormRequest
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


        return [
            'user_id'=>['required'],
            'shipping_address'=>['nullable'],
             'total_price'=>['required'],
            // function($attributes,$value,$fail)use($cart){
            //     $calculatedTotal= $cart ? $cart->cartitems->sum(function($cartitem){
            //         return $cartitem->quantity * $cartitem->product->price;
            //     }) : 0;
            //     if($value!=$calculatedTotal){
            //         $fail('Total AMount Incorrect');
            //     }
            // }

        ];
    }
}

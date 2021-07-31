<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSlipPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject_id' => 'required',
            'is_cash' => 'required',
            'accrual_year' => 'required',
            'accrual_month' => 'required|digits_between:1,12',
            'accrual_date' => 'required|digits_between:1,31',
            'price' => 'required',
            'subtotal' => 'required',
            'sales_tax_rate' => 'required',
            'sales_tax' => 'required',
            'grand_total' => 'required',
            'remarks' => 'max:300',
        ];
    }
}

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

    public function getValidatorInstance()
    {
        // プルダウンで選択された値(= 配列)を取得
        $accrual_year = $this->input('accrual_year');
        $accrual_month = $this->input('accrual_month');
        $accrual_date = $this->input('accrual_date');

        $date = [$accrual_year, $accrual_month, $accrual_date];

        // 日付を作成(ex. 2020-1-20)
        $accrual_year_validation = implode('-', $date);

        // rules()に渡す値を追加でセット
        //     これで、この場で作った変数にもバリデーションを設定できるようになる
        $this->merge([
            'accrual_year_validation' => $accrual_year_validation,
        ]);

        return parent::getValidatorInstance();
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
            'accrual_year_validation' => 'required|before:today',
            // 'accrual_year' => 'required',
            // 'accrual_month' => 'required|digits_between:1,12',
            // 'accrual_date' => 'required|digits_between:1,31',
            'price' => 'required',
            'subtotal' => 'required',
            'sales_tax_rate' => 'required',
            'sales_tax' => 'required',
            'grand_total' => 'required',
            'remarks' => 'max:300',
        ];
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Slip extends Model
{
    protected $table = 'slips';

    protected $fillable = [
        'subject_id',
        'is_cash',
        'accrual_year',
        'accrual_month',
        'accrual_date',
        'price',
        'subtotal',
        'sales_tax_rate',
        'sales_tax',
        'grand_total',
        'remarks',
        'annual_confirmation',
    ];

     /**
     * この伝票の科目を取得
     */
    public function subject()
    {
        return $this->belongsTo('App\Model\Subject');
    }

}

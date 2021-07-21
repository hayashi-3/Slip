<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Slip extends Model
{
    protected $table = 'slips';

    protected $fillable = [
        'subject_id',
        'accrual_date',
        'price',
        'subtotal',
        'sales_tax_rate',
        'sales_tax',
        'grand_total',
        'remarks',
    ];

     /**
     * この伝票の科目を取得
     */
    public function subject()
    {
        return $this->belongsTo('App\Model\Subject');
    }

     /**
     * この伝票の月間を取得
     */
    public function month_summary()
    {
        return $this->belongsTo('App\Model\Month_summary');
    }
}

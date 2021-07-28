<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Month_summary extends Model
{
    protected $table = 'month_summaries';

    protected $fillable = [
        'subject_id',
        'month',
        'monthly_subtotal',
        'monthly_sales_tax',
        'subtotal',
        'monthly_grand_total',
    ];

     /**
     * 月間サマリーの科目を取得
     */
    public function m_subject()
    {
        return $this->belongsTo('App\Model\Subject');
    }

}

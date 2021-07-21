<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Month_summary extends Model
{
    protected $table = 'month_summaries';

    /**
     * 紐づく伝票を取得
     */
    public function month_slips()
    {
        return $this->hasMany('App\Model\Slip');
    }
}

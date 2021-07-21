<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
        'subject_name',
        'calculation',
    ];

    /**
     * 紐づく伝票を取得
     */
    public function subject_slips()
    {
        return $this->hasMany('App\Model\Slip');
    }
}

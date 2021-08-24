<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Years_summary extends Model
{
    protected $table = 'years_summaries';

    protected $fillable = [
        'subject_id',
        'accountin_year',
        'year_subtotal',
        'year_sales_tax',
        'year_grand_total',
        'confirm',
    ];
}

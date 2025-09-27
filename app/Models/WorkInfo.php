<?php

namespace App\Models;

use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;

class WorkInfo extends Model
{
    protected $guarded = [];

    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
    
    protected $casts = [
        'work_exp_date_from' => 'date',
        'work_exp_date_to' => 'date',
    ];
}

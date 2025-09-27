<?php

namespace App\Models;

use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;

class PreviousTravelInfo extends Model
{
    protected $guarded = [];

    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
}

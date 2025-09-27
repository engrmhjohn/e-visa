<?php

namespace App\Models;

use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;

class EducationInfo extends Model
{
    protected $guarded = [];

        public function applicationForms()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
}

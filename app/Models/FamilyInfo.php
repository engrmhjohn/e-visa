<?php

namespace App\Models;

use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;

class FamilyInfo extends Model
{
    protected $guarded = [];

    public function applicationForms()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
    public function fatherNationality()
    {
        return $this->belongsTo(Country::class, 'father_nationality_id');
    }

    public function motherNationality()
    {
        return $this->belongsTo(Country::class, 'mother_nationality_id');
    }

    public function childrenNationality()
    {
        return $this->belongsTo(Country::class, 'children_nationality_id');
    }

    protected $casts = [
        'children_dob' => 'date',
        'mother_dob' => 'date',
        'father_dob' => 'date',
    ];
}

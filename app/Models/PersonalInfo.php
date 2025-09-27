<?php

namespace App\Models;

use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    protected $guarded = [];

    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class);
    }

    public function birthCountry()
    {
        return $this->belongsTo(Country::class, 'birth_country_id');
    }

    public function currentNationality()
    {
        return $this->belongsTo(Country::class, 'current_nationality_id');
    }

    public function issuingCountry()
    {
        return $this->belongsTo(Country::class, 'issuing_country_id');
    }

    protected $casts = [
        'dob' => 'date',
        'passport_expiration_date' => 'date',
    ];
}

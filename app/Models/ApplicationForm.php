<?php

namespace App\Models;

use App\Models\User;
use App\Models\Material;
use App\Models\VisaType;
use App\Models\WorkInfo;
use App\Models\OtherInfo;
use App\Models\FamilyInfo;
use App\Models\TravelInfo;
use App\Models\Declaration;
use App\Models\PersonalInfo;
use App\Models\EducationInfo;
use App\Models\PreviousTravelInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $guarded = [];

    // One application belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class); // Remove 'application_id'
    }

    // One application has one personal info
    public function personalInfo()
    {
        return $this->hasOne(PersonalInfo::class, 'application_id');
    }

    // One application has one visa type
    public function visaType()
    {
        return $this->hasOne(VisaType::class, 'application_id');
    }

    // One application has one Work Information
    public function workInfo()
    {
        return $this->hasOne(WorkInfo::class, 'application_id');
    }

    // One application has many educations
    public function educationInfo()
    {
        return $this->hasOne(EducationInfo::class, 'application_id');
    }

    // One application has many family members
    public function familyInfo()
    {
        return $this->hasOne(FamilyInfo::class, 'application_id');
    }

    // One application has many travel information
    public function travelInfo()
    {
        return $this->hasOne(TravelInfo::class, 'application_id');
    }

    // One application has one previous travel info
    public function previousTravelInfo()
    {
        return $this->hasOne(PreviousTravelInfo::class, 'application_id');
    }

    // One application has one other info
    public function otherInfo()
    {
        return $this->hasOne(OtherInfo::class, 'application_id');
    }

    // One application has one declaration
    public function declaration()
    {
        return $this->hasOne(Declaration::class, 'application_id');
    }

    // One application has one materials
    public function materials()
    {
        return $this->hasOne(Material::class, 'application_id');
    }

    protected $casts = [
        'submitted_at' => 'date',
    ];
}

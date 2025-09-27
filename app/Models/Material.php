<?php

namespace App\Models;

use App\Models\ApplicationForm;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $guarded = [];

    public function application()
    {
        return $this->belongsTo(ApplicationForm::class);
    }
}

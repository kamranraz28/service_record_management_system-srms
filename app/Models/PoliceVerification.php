<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\Auditable;

class PoliceVerification extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Auditable;

    public $table = 'police_verifications';

    protected $appends = [
        'applicant_form',
        'verified_form',
    ];

    protected $fillable = [
        'verification_type',
        'employee_id',
    ];

    /**
     * Accessor for Applicant Form
     */
    public function getApplicantFormAttribute()
    {
        return $this->getMedia('applicant_form')->last();
    }
    public function getVerifiedFormAttribute()
    {
        return $this->getMedia('verified_form')->last();
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeList::class, 'employee_id');
    }

}

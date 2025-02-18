<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\Auditable;

class Other extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Auditable;

    public $table = 'others';

    protected $appends = [
        'health_paper',
    ];

    protected $fillable = [
        'employee_id',
        'possible_date',
        'office'
    ];

    /**
     * Accessor for Applicant Form
     */
    public function getHealthPaperAttribute()
    {
        return $this->getMedia('health_paper')->last();
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeList::class, 'employee_id');
    }

}

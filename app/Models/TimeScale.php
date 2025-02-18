<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\Auditable;

class TimeScale extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Auditable;

    public $table = 'time_scales';

    protected $appends = [
        'office_order',
    ];

    protected $fillable = [
        'employee_id',
        'type',
        'receipt_date',
        'order_date',
    ];

    /**
     * Accessor for Applicant Form
     */
    public function getOfficeOrderAttribute()
    {
        return $this->getMedia('office_order')->last();
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeList::class, 'employee_id');
    }

}

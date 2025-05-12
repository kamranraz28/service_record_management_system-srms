<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CriminalProsecutione extends Model implements HasMedia
{
    use InteractsWithMedia, Auditable, HasFactory;

    protected $appends = [
        'court_order',
		'court_order_new',
		'appeal_order',
    ];

    public $table = 'criminal_prosecutiones';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'employee_id',
        'judgement_type',
        'natureof_offence',
        'government_order_no',
        'remzrk',
        'created_at',
        'updated_at',
        'deleted_at',
		'mamla_id',
		'situation_id',
		'mamla_start',
		'mamla_end',
		'mamla_result',
		'appeal_go',
		'appeal_result',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeList::class, 'employee_id');
    }

	public function mamla()
    {
        return $this->belongsTo(MamlaType::class, 'mamla_id');
    }

	public function situation()
    {
        return $this->belongsTo(MamlaSituation::class, 'situation_id');
    }

    public function criminalprosecutione(){
        return $this->hasMany(CriminalProsecutionDerail::class,'criminalprosecutione_id');
    }

    public function getCourtOrderAttribute()
    {
        return $this->getMedia('court_order')->last();
    }

	public function getCourtOrderNewAttribute()
    {
        return $this->getMedia('court_order_new')->last();
    }

	public function getAppealOrderAttribute()
    {
        return $this->getMedia('appeal_order')->last();
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TransferLog extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'transfer_logs';


    protected $fillable = [
        'employee_id',
		'previous_office_id',
		'division_id',
		'circle_id',
		'transfer_date',
		'comment',
    ];
	
	public function employee()
    {
        return $this->belongsTo(EmployeeList::class, 'employee_id');
    }
	
	public function division()
    {
        return $this->belongsTo(User::class, 'division_id');
    }
	
	public function circle()
    {
        return $this->belongsTo(User::class, 'circle_id');
    }

}

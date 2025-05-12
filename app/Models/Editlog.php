<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Editlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'form',
        'field',
        'level',
        'data_id',
        'content',
        'edit_by',
        'employee_id',
        'status',
        'created_at',
        'updated_at',
    ];

    // Dynamic form model mapping
    public function getFormModelAttribute()
    {
        $map = [
            1 => EmployeeList::class,
            2 => EducationInformatione::class,
            3 => Professionale::class,
            4 => Addressdetaile::class,
            5 => EmergenceContacte::class,
            6 => SpouseInformatione::class,
            7 => Child::class,
            8 => JobHistory::class,
            9 => EmployeePromotion::class,
            10 => LeaveRecord::class,
            11 => Training::class,
            12 => TravelRecord::class,
            13 => Extracurriculam::class,
            14 => Publication::class,
            15 => Award::class,
            16 => OtherServiceJob::class,
            17 => CriminalProsecutione::class,
            18 => AcrMonitoring::class,
            19 => TimeScale::class,
            20 => PoliceVerification::class,
            21 => Other::class,
        ];

        return $map[$this->form] ?? null;
    }

    // Dynamic dropdown field-to-model mapping
    public function getDropdownMapAttribute()
    {
        return [
            'name_of_exam_id' => Examination::class,
            'exam_degree' => ExamDegree::class,
            'exam_board_id' => ExamBoard::class,
            'result_id' => Result::class,
            'thana_upazila_id' => Upazila::class,
            'office_unit_id' => OfficeUnit::class,
            'circle_list_id' => ForestState::class,
            'division_list_id' => ForestDivision::class,
            'range_list_id' => ForestRange::class,
            'beat_list_id' => ForestBeat::class,
            'designation_id' => Designation::class,
            'grade_id' => Grade::class,
            'new_designation_id' => Designation::class,
            'leave_category_id' => LeaveCategory::class,
            'type_of_leave_id' => LeaveType::class,
            'country_id' => Country::class,
            'title_id' => TravelTitle::class,
            'mamla_id' => MamlaType::class,
            'situation_id' => MamlaSituation::class,
            // Add more if needed
        ];
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeList::class, 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'edit_by');
    }

    public function getPreviousDataAttribute()
    {
        $modelClass = $this->form_model;
        if (!$modelClass || !$this->field || !$this->employee_id)
            return null;

        // Try to locate record by `data_id` first, fallback to `employee_id`
        $record = $modelClass::where(function ($query) {
            $query->where('id', $this->data_id);
        })->first();

        if (!$record)
            return null;

        if ($this->type == 3) {
            return 'N/A';
        }

        if (!isset($record->{$this->field}))
            return null;

        $value = $record->{$this->field};

        // Dropdown mapping
        if ($this->type == 2) {
            $dropdownModel = $this->dropdown_map[$this->field] ?? null;
            return $dropdownModel ? $dropdownModel::find($value)->name_bn ?? 'N/A' : 'N/A';
        }

        return $value;
    }


    public function getFormattedContentAttribute()
    {
        if ($this->type == 2) {
            $model = $this->dropdown_map[$this->field] ?? null;
            return $model ? $model::find($this->content)->name_bn ?? 'N/A' : 'N/A';
        }

        if ($this->type == 3 && $this->form_model && $this->data_id) {
            $modelInstance = ($this->form_model)::find($this->data_id);
            if ($modelInstance) {
                $media = $modelInstance->getMedia($this->field)->last();
                if ($media) {
                    return '<a href="' . $media->getUrl() . '" target="_blank">View New File</a>';
                }
            }

            return 'File not found';
        }

        return $this->content;
    }


    public function relatedData()
    {
        return $this->form_model
            ? $this->belongsTo($this->form_model, 'data_id')
            : null;
    }
}

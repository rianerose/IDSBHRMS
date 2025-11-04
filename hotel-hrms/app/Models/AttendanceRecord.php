<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'attendance_date',
        'check_in',
        'check_out',
        'status',
        'notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function hoursWorked(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->attendance_date || !$this->check_in || !$this->check_out) {
                return 0.0;
            }

            $start = Carbon::createFromFormat('Y-m-d H:i', $this->attendance_date->format('Y-m-d') . ' ' . $this->check_in);
            $end = Carbon::createFromFormat('Y-m-d H:i', $this->attendance_date->format('Y-m-d') . ' ' . $this->check_out);

            if ($end->lessThanOrEqualTo($start)) {
                $end = $end->addDay();
            }

            return round($start->floatDiffInHours($end), 2);
        });
    }
}

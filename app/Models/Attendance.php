<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Attendance extends Model
{
    protected $fillable = [
        'date', 'status', 'employee_id'
    ];

    protected $timestamp = true;

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

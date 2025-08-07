<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Employee extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'department_id', 'name', 'email', 'phone', 'address'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}

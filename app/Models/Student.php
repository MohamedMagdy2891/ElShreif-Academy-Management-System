<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable =['name','phone1','phone2','date','barcode','row_id','user_create'];

    protected $hidden = ['created_at','updated_at'];

    public function Row()
    {
        return $this->belongsTo(Row::class,'row_id','id');
    }
    public function User()
    {
        return $this->belongsTo(User::class,'user_create','id');
    }
    public function StudentAttendance()
    {
        return $this->hasMany(StudentAttendance::class);
    }
    public function Salary()
    {
        return $this->hasMany(Salary::class);
    }
}

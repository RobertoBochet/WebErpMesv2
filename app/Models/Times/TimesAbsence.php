<?php

namespace App\Models\Times;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimesAbsence extends Model
{
    use HasFactory;

    protected $fillable = ['user_id',  'absence_type',  'absence_type_day',  'statu',  'START_DATE',  'END_DATE'];

    public function User()
{
    return $this->belongsTo(User::class, 'user_id');
}
}



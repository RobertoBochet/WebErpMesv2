<?php

namespace App\Models\Quality;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quality\QualityNonConformity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QualityDerogation extends Model
{
    use HasFactory;

    protected $fillable = ['CODE',
    'LABEL', 
    'statu',
    'TYPE', 
    'user_id',
    'service_id',  
    'PB_DESCP',  
    'PROPOSAL', 
    'REPLY', 
    'quality_non_conformitie_id',  
    'DECISION'];

    public function UserManagement()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function QualityNonConformity()
    {
        return $this->belongsTo(QualityNonConformity::class, 'quality_non_conformities_id');
    }
    
    public function GetPrettyCreatedAttribute()
    {
        return date('d F Y', strtotime($this->created_at));
    }
}

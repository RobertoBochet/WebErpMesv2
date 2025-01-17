<?php

namespace App\Models\Methods;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Methods\MethodsRessources;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MethodsSection extends Model
{
    use HasFactory;

    protected $fillable = ['ORDRE','CODE', 'LABEL', 'user_id','COLOR'];

    public function UserManagement()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Ressources()
    {
        return $this->hasMany(MethodsRessources::class);
    }

}

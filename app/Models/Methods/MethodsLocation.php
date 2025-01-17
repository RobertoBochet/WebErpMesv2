<?php

namespace App\Models\Methods;

use Illuminate\Database\Eloquent\Model;
use App\Models\Methods\MethodsRessources;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MethodsLocation extends Model
{
    use HasFactory;

    protected $fillable = ['CODE',  'LABEL',  'ressource_id', 'COLOR'];

    public function ressources()
    {
        return $this->belongsTo(MethodsRessources::class, 'ressource_id');
    }
}

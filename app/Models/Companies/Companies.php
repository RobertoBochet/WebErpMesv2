<?php

namespace App\Models\Companies;

use App\Models\Companies\companiesContacts;
use App\Models\Companies\companiesAddresses;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Companies extends Model
{
    use HasFactory;

    protected $fillable = ['CODE', 
                            'LABEL',
                            'WEBSITE',
                            'FBSITE',
                            'TWITTERSITE', 
                            'LKDSITE', 
                            'SIREN', 
                            'APE', 
                            'TVA_INTRA', 
                            'TVA_ID', 
                            'STATU_CLIENT',
                            'DISCOUNT',
                            'user_id',
                            'COMPTE_GEN_CLIENT',
                            'COMPTE_AUX_CLIENT',
                            'STATU_FOUR',
                            'COMPTE_GEN_FOUR',
                            'COMPTE_AUX_FOUR',
                            'RECEPT_CONTROLE',
                            'COMMENT'
                        ];

    public function Addresses()
    {
        return $this->hasMany(companiesAddresses::class);
    }

    public function Contacts()
    {
        return $this->hasMany(companiesContacts::class);
    }

    public function UserManagement()
    {
        return $this->hasOne(User::class);
    }
    
    public function Vat()
    {
        return $this->hasOne(acVat::class);
    }

    public function GetPrettyCreatedAttribute()
    {
        return date('d F Y', strtotime($this->created_at));
    }
}
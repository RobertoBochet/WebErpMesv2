<?php

namespace App\Models\Workflow;

use App\Models\User;
use App\Models\Companies\Companies;
use App\Models\Workflow\InvoiceLines;
use Illuminate\Database\Eloquent\Model;
use App\Models\Companies\CompaniesContacts;
use App\Models\Companies\CompaniesAddresses;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoices extends Model
{
    use HasFactory;

    protected $fillable = ['CODE', 
                            'LABEL', 
                            'companies_id', 
                            'companies_contacts_id',   
                            'companies_addresses_id',  
                            'statu',
                            'invoice_type',
                            'accounting_status',
                            'user_id',
                            'bank_id',
                            'comment',
                            'order_id',
                            ];


    public function companie()
    {
        return $this->belongsTo(Companies::class, 'companies_id');
    }

    public function contact()
    {
        return $this->belongsTo(CompaniesContacts::class, 'companies_contacts_id');
    }

    public function adresse()
    {
        return $this->belongsTo(CompaniesAddresses::class, 'companies_addresses_id');
    }

    public function UserManagement()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function InvoiceLines()
    {
        return $this->hasMany(InvoiceLines::class)->orderBy('ORDRE');
    }

    public function GetPrettyCreatedAttribute()
    {
        return date('d F Y', strtotime($this->created_at));
    }
}

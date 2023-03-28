<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourcingInvoice extends Model
{
    use HasFactory;
    
    protected $table='sg_sourcing_invoices';
    protected $primaryKey = 'sourcing_invoice_id';

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberTempInvoiceItems extends Model
{
    use HasFactory;
    
    protected $table='sg_member_temp_invoice_items';
    protected $primaryKey = 'temp_invoice_item_id';
}

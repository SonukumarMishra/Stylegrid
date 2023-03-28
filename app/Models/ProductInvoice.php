<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInvoice extends Model
{
    use HasFactory;
    
    protected $table='sg_product_invoices';
    protected $primaryKey = 'product_invoice_id';

}

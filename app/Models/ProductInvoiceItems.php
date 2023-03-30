<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInvoiceItems extends Model
{
    use HasFactory;
    
    protected $table='sg_product_invoices_items';
    protected $primaryKey = 'product_invoice_item_id';

}

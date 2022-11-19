<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StyleGridProductDetails extends Model
{
    use HasFactory;
    
    protected $table='sg_stylegrid_product_details';
    protected $primaryKey = 'stylegrid_product_id';
}

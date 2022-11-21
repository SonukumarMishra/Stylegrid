<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StyleGridDetails extends Model
{
    use HasFactory;
    
    protected $table='sg_stylegrid_details';
    protected $primaryKey = 'stylegrid_dtls_id';
}

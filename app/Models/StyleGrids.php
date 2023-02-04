<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StyleGrids extends Model
{
    use HasFactory;
    
    protected $table='sg_stylegrids';
    protected $primaryKey = 'stylegrid_id';

    public function stylegrid_products() 
    {
        return $this->hasMany(StyleGridProductDetails::class, 'stylegrid_id', 'stylegrid_id');
    }

}

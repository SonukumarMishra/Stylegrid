<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class PaymentTransaction extends Model
{
    public $db;
	
	protected $table='sg_payment_transactions';
    protected $primaryKey = 'payment_trans_id';

}
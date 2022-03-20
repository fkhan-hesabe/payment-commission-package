<?php

namespace Hesabe\PaymentCommission\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $primaryKey = 'PaymentTypeID';
    protected $table = 'PaymentTypeMaster';
}

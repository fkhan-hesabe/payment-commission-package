<?php

namespace Hesabe\PaymentCommission\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantPaymentSubscription extends Model
{
    protected $guarded = [];

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id', 'PaymentTypeID');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id', 'ServiceTypeID');
    }
}
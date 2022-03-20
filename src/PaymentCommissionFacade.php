<?php

namespace Hesabe\PaymentCommission;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hesabe\PaymentCommission\Skeleton\SkeletonClass
 * @method static getAll(int $merchantId)
 * @method static updateOrCreate(int $merchantId, int $paymentTypeId, int $serviceTypeId, float $percentage, float $fixed, bool $status)
 * @method static updateOrCreateStatus(int $merchantId, int $paymentTypeId, int $serviceTypeId, bool $status)
 * @method static calculate(int $merchantId, int $serviceTypeId, int $paymentTypeId, float $amount)
 * @method static removeAll(int $merchantId)
 */

class PaymentCommissionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'PaymentCommission';
    }
}

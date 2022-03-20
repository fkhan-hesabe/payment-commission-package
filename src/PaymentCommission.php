<?php

namespace Hesabe\PaymentCommission;

use Hesabe\PaymentCommission\Models\MerchantPaymentSubscription;
use Hesabe\PaymentCommission\Contracts\PaymentCommissionContract;

class PaymentCommission implements PaymentCommissionContract
{
    public function getAll($merchantId)
    {
        return MerchantPaymentSubscription::query()
            ->where('merchant_id', $merchantId)
            ->with('paymentType', 'serviceType')
            ->get();
    }

    public function getGrouped($merchantId)
    {
        $subscriptions = MerchantPaymentSubscription::query()
            ->select('service_type_id', 'payment_type_id', 'fixed', 'percentage')
            ->where('merchant_id', $merchantId)
            ->get();

        $collection = collect($subscriptions);

        $grouped = $collection->groupBy('service_type_id')
            ->map(function ($item, $key) {
                return [
                    'id' => $key,
                    'payment_types' => $item->map(function ($paymentTypes) {
                        return [
                            'id' => $paymentTypes->payment_type_id,
                            'fixed' => $paymentTypes->fixed,
                            'percentage' => $paymentTypes->percentage,
                        ];
                    })
                ];
            });

        return [
            'service_types' => $grouped->toArray()
        ];
    }

    public function updateOrCreate($merchantId, $paymentTypeId, $serviceTypeId, $percentage = 0, $fixed = 0, $status = true)
    {
        return MerchantPaymentSubscription::updateOrCreate([
            'merchant_id' => $merchantId,
            'payment_type_id' => $paymentTypeId,
            'service_type_id' => $serviceTypeId
            ], [
            'percentage' => $percentage,
            'fixed' => $fixed,
            'status' => $status
        ]);
    }
    
    public function updateOrCreateStatus($merchantId, $paymentTypeId, $serviceTypeId, $status = true)
    {
        return MerchantPaymentSubscription::updateOrCreate([
            'merchant_id' => $merchantId,
            'payment_type_id' => $paymentTypeId,
            'service_type_id' => $serviceTypeId
            ], [
            'status' => $status
        ]);
    }

    public function calculate($merchantId, $serviceTypeId = 3, $paymentTypeId, $amount)
    {
        $fixed = 0;
        $percentage = 0;
        $percentageValue = 0;

        $merchantComission = MerchantPaymentSubscription::query()
            ->where('merchant_id', $merchantId)
            ->where('service_type_id', $serviceTypeId)
            ->where('payment_type_id', $paymentTypeId)
            ->where('status', true)
            ->first();

        $fixed = $merchantComission->fixed;
        $percentage = $merchantComission->percentage;

        if ($percentage > 0) {
            $percentageValue = ($amount * ($percentage / 100));
        }

        $commission = $percentageValue + $fixed;

        $finalAmount = $amount - $commission;

        return [
            'finalAmount' => $finalAmount,
            'commission' => $commission
        ];
    }

    public function removeAll($merchantId)
    {
        return MerchantPaymentSubscription::query()
            ->where('merchant_id', $merchantId)
            ->delete();
    }
}

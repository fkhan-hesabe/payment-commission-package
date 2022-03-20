<?php

namespace Hesabe\PaymentCommission\Contracts;

interface PaymentCommissionContract
{
		public function getAll($merchantId);

		public function updateOrCreate($merchantId, $paymentTypeId, $serviceTypeId, $percentage = 0, $fixed = 0);

		public function calculate($merchantId, $serviceTypeId, $paymentTypeId, $amount);

		public function removeAll($merchantId);
}
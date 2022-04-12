<?php

namespace Botble\Payment\Repositories\Caches;

use Botble\Payment\Repositories\Interfaces\PaymentInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class PaymentCacheDecorator extends CacheAbstractDecorator implements PaymentInterface
{

}

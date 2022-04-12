<?php

namespace Botble\Contact\Repositories\Caches;

use Botble\Contact\Repositories\Interfaces\ContactInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class ContactCacheDecorator extends CacheAbstractDecorator implements ContactInterface
{
    /**
     * {@inheritDoc}
     */
    public function getUnread($select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function countUnread()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}

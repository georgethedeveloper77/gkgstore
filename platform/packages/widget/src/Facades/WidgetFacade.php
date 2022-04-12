<?php

namespace Botble\Widget\Facades;

use Botble\Widget\WidgetGroup;
use Illuminate\Support\Facades\Facade;

class WidgetFacade extends Facade
{
    /**
     * Get the widget group object.
     *
     * @param string $name
     *
     * @return WidgetGroup
     */
    public static function group($name)
    {
        return app('botble.widget-group-collection')->group($name);
    }

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'botble.widget';
    }
}

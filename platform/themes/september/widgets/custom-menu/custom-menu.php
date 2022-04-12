<?php

use Botble\Widget\AbstractWidget;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CustomMenuWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected $widgetDirectory = 'custom-menu';

    /**
     * CustomMenuWidget constructor.
     * @throws FileNotFoundException
     */
    public function __construct()
    {
        parent::__construct([
            'name' => __('Custom Menu'),
            'description' => __('Add a custom menu to your widget area.'),
            'menu_id' => null,
        ]);
    }
}

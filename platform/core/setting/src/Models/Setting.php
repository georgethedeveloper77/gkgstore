<?php

namespace Botble\Setting\Models;

use Botble\Base\Models\BaseModel;

class Setting extends BaseModel
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';
    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];
}

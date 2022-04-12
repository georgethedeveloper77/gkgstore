<?php

use Botble\Base\Models\BaseModel;

if (!function_exists('table_checkbox')) {
    /**
     * @param int $id
     * @return string
     * @throws Throwable
     */
    function table_checkbox($id): string
    {
        return view('core/table::partials.checkbox', compact('id'))->render();
    }
}

if (!function_exists('table_actions')) {
    /**
     * @param string $edit
     * @param string $delete
     * @param BaseModel $item
     * @param string $extra
     * @return string
     * @throws Throwable
     */
    function table_actions($edit, $delete, $item, $extra = null): string
    {
        return view('core/table::partials.actions', compact('edit', 'delete', 'item', 'extra'))->render();
    }
}

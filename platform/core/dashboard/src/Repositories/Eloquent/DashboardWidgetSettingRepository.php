<?php

namespace Botble\Dashboard\Repositories\Eloquent;

use Botble\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Support\Facades\Auth;

class DashboardWidgetSettingRepository extends RepositoriesAbstract implements DashboardWidgetSettingInterface
{
    /**
     * {@inheritDoc}
     */
    public function getListWidget()
    {
        $data = $this->model
            ->select([
                'id',
                'order',
                'settings',
                'widget_id',
            ])
            ->with('widget')
            ->orderBy('order')
            ->where('user_id', Auth::user()->getKey())
            ->get();

        $this->resetModel();

        return $data;
    }
}

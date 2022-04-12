<?php

namespace Botble\Blog\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Blog\Repositories\Interfaces\TagInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class TagRepository extends RepositoriesAbstract implements TagInterface
{

    /**
     * {@inheritDoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('tags.status', BaseStatusEnum::PUBLISHED)
            ->select('tags.*')
            ->orderBy('tags.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getPopularTags($limit)
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('tags.id', 'DESC')
            ->select('tags.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritDoc}
     */
    public function getAllTags($active = true)
    {
        $data = $this->model->select('tags.*');
        if ($active) {
            $data = $data->where('tags.status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}

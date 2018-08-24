<?php

namespace LaraCed;

use Illuminate\Database\Eloquent\Model;

class LaraCedObserver
{

    /**
     * Get User id.
     *
     * @return int
     */
    protected function getUserId()
    {
        return auth()->id();
    }

    public function creating(Model $model)
    {
        $model -> {$model -> getCreatorColumn()} = $this->getUserId();
    }

    public function updating(Model $model)
    {
        if ($model->isDirty()) {
            $model -> {$model -> getEditorColumn()} = $this->getUserId();
        }
    }

    public function deleting(Model $model)
    {
        $model -> {$model -> getDestroyerColumn()} = $this->getUserId();
    }
}
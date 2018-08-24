<?php

namespace LaraCed;

use Illuminate\Database\Eloquent\Builder;

trait LaraCedTrait
{
    

    public static function bootLaraCedTrait()
    {
        static::observe(new LaraCedObserver);
    }

    /**
     * Has the model loaded the SoftDeletes trait.
     *
     * @return bool
     */
    public static function isUseSoftDeletes()
    {
        static $isUseSoftDeletes;
        if (is_null($isUseSoftDeletes)) {
            return $isUseSoftDeletes = in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive(get_called_class()));
        }
        return $isUseSoftDeletes;
    }

    /**
     *  Get user model
     */
    public function getUserModel()
    {
        $class = config('auth.providers.users.model');
        return $class;
    }

    /**
     * Get the name of the "creator" column.
     *
     * @return string
     */
    public function getCreatorColumn()
    {
        return defined('static::CREATOR_COLUMN') ? static::CREATOR_COLUMN : 'created_by';
    }

    /**
     * Get the name of the "editor" column.
     *
     * @return string
     */
    public function getEditorColumn()
    {
        return defined('static::EDITOR_COLUMN') ? static::EDITOR_COLUMN : 'updated_by';
    }

    /**
     * Get the name of the "destroyer" column.
     *
     * @return string
     */
    public function getDestroyerColumn()
    {
        return defined('static::DESTROYER_COLUMN') ? static::DESTROYER_COLUMN : 'deleted_by';
    }

    /**
     * Creator, relation with user model
     */
    public function creator()
    {
        return $this->belongsTo($this->getUserModel(), $this->getCreatorColumn());
    }

    /**
     * Editor, relation with user model
     */
    public function editor()
    {
        return $this->belongsTo($this->getUserModel(), $this->getEditorColumn());
    }

    /**
     * Destroyer, relation with user model
     */
    public function destroyer()
    {
        return $this->belongsTo($this->getUserModel(), $this->getDestroyerColumn());
    }

}
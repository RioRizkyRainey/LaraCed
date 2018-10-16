<?php

namespace LaraCed;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class LaraCedServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $userClass = config('auth.providers.users.model');

        $userClass = new $userClass;

        $userModel = $userClass->getTable();

        Blueprint::macro('ced', function () {
            $this->unsignedInteger('created_by')->nullable()->index();
            $this->unsignedInteger('updated_by')->nullable()->index();
            $this->unsignedInteger('deleted_by')->nullable()->index();
        });

        Blueprint::macro('creator', function ($name = 'created_by') {
            $this->unsignedInteger($name)->nullable()->index();
        });
        Blueprint::macro('editor', function ($name = 'updated_by') {
            $this->unsignedInteger($name)->nullable()->index();
        });
        Blueprint::macro('destroyer', function ($name = 'deleted_by') {
            $this->unsignedInteger($name)->nullable()->index();
        });

        Blueprint::macro('dropCreator', function ($name = 'created_by') {
            $this->dropColumn($name);
        });
        Blueprint::macro('dropEditor', function ($name = 'updated_by') {
            $this->dropColumn($name);
        });
        Blueprint::macro('dropDestroyer', function ($name = 'deleted_by') {
            $this->dropColumn($name);
        });

        Blueprint::macro('dropCed', function () {
            $this->dropColumn(['created_by', 'updated_by', 'deleted_by']);
        });

        Blueprint::macro('cedForeign', function () use ($userModel) {
            $tableName = $this->getTable();

            $this->foreign('created_by', 'fk_' . $tableName . 'has_created_by')->references('id')->on($userModel)->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $this->foreign('updated_by', 'fk_' . $tableName . 'has_updated_by')->references('id')->on($userModel)->onUpdate('NO ACTION')->onDelete('NO ACTION');

            $this->foreign('deleted_by', 'fk_' . $tableName . 'has_deleted_by')->references('id')->on($userModel)->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Blueprint::macro('creatorForeign', function ($name = 'created_by') use ($userModel) {
            $tableName = $this->getTable();

            $this->foreign($name, 'fk_' . $tableName . 'has_' . $name)->references('id')->on($userModel)->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Blueprint::macro('editorForeign', function ($name = 'updated_by') use ($userModel) {
            $tableName = $this->getTable();

            $this->foreign($name, 'fk_' . $tableName . 'has_' . $name)->references('id')->on($userModel)->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Blueprint::macro('destroyerForeign', function ($name = 'deleted_by') use ($userModel) {
            $tableName = $this->getTable();

            $this->foreign($name, 'fk_' . $tableName . 'has_' . $name)->references('id')->on($userModel)->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        //Drop CED Foreign
        Blueprint::macro('dropCreatorForeign', function ($name = 'created_by') use ($userModel) {
            $tableName = $this->getTable();

            $this->dropForeign('fk_' . $tableName . 'has_' . $name);
        });

        Blueprint::macro('dropEditorForeign', function ($name = 'updated_by') use ($userModel) {
            $tableName = $this->getTable();

            $this->dropForeign('fk_' . $tableName . 'has_' . $name);
        });

        Blueprint::macro('dropDestroyerForeign', function ($name = 'deleted_by') use ($userModel) {
            $tableName = $this->getTable();

            $this->dropForeign('fk_' . $tableName . 'has_' . $name);
        });

        Blueprint::macro('dropCedForeign', function () use ($userModel) {
            $tableName = $this->getTable();

            $this->dropForeign('fk_' . $tableName . '_has_created_by');
            $this->dropForeign('fk_' . $tableName . '_has_updated_by');
            $this->dropForeign('fk_' . $tableName . '_has_deleted_by');
        });
    }
}

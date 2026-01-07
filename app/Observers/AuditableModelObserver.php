<?php

namespace App\Observers;

use App\Services\ActivityLogger;

class AuditableModelObserver
{
    /**
     * Handle the model "created" event.
     */
    public function created($model): void
    {
        $modelName = class_basename($model);
        ActivityLogger::logCreated($modelName, $model);
    }

    /**
     * Handle the model "updated" event.
     */
    public function updated($model): void
    {
        $modelName = class_basename($model);
        $changes = $model->getChanges();
        ActivityLogger::logUpdated($modelName, $model, $changes);
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted($model): void
    {
        $modelName = class_basename($model);
        ActivityLogger::logDeleted($modelName, $model);
    }

    /**
     * Handle the model "restored" event.
     */
    public function restored($model): void
    {
        $modelName = class_basename($model);
        ActivityLogger::log('restored', "Restored {$modelName} (ID: {$model->getKey()})");
    }

    /**
     * Handle the model "force deleted" event.
     */
    public function forceDeleted($model): void
    {
        // Already handled by deleted event
    }
}

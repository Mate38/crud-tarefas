<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskTag extends Pivot
{
    protected $table = 'task_tags';

    public static function getTableName()
    {
        return (new self)->table;
    }
}

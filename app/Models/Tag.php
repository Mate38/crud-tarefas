<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'tags';

	protected $fillable = [
		'cod',
		'title',
		'description'
	];

	protected $dates = [
		'created_at'
	];

	public function tasks()
    {
        return $this->belongsToMany(Task::class, TaskTag::getTableName());
    }

}

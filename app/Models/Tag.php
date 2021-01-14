<?php

namespace App\Models;

use App\Models\Generic\UserExclusive;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends UserExclusive
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

	protected $hidden = [
        'user_id',
    ];

	public function tasks()
    {
        return $this->belongsToMany(Task::class, TaskTag::getTableName());
	}

}

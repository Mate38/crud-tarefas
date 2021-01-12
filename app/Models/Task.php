<?php

namespace App\Models;

use App\Models\TaskTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'tasks';

	protected $fillable = [
		'cod',
		'title',
		'description',
		'status'
	];

	protected $dates = [
		'created_at'
	];

	public function tags()
    {
        return $this->belongsToMany(Tag::class, TaskTag::getTableName());
    }

	const STATUS_ACTIVE = 1;
	const STATUS_CONCLUDED = 2;
	const STATUS_ARCHIVED = 3;

	public function scopeStatusActive($query) {
		return $query->where('status', self::STATUS_ACTIVE);
	}

	public function scopeStatusConcluded($query) {
		return $query->where('status', self::STATUS_CONCLUDED);
	}

	public function scopeStatusArchived($query) {
		return $query->where('status', self::STATUS_ARCHIVED);
	}

	public function scopeCreatedToday($query) {
		return $query->whereRaw('Date(created_at) = CURDATE()');
	}

	public function scopeFilters($query, $filters) {

		if($cod = data_get($filters, 'cod')) {
			$query->where('cod', 'LIKE', '%'. $cod .'%');
		}

		if($title = data_get($filters, 'title')) {
			$query->where('title', 'LIKE', '%'. $title .'%');
		}

		if($created = data_get($filters, 'created')) {
			$query->whereDate('created_at', $created);
		}

		if($status = data_get($filters, 'status')) {
			$query->where('status', $status);
		}

		return $query;
	}
}

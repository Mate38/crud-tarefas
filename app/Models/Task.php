<?php

namespace App\Models;

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

	const STATUS_ACTIVE = 1;
	const STATUS_CONCLUDED = 2;
	const STATUS_ARCHIVED = 3;

	public function getStatusAttribute($value) {
		switch ($value) {
			case self::STATUS_ACTIVE:
				return 'Ativa';
			case self::STATUS_CONCLUDED:
				return 'Concluída';
			case self::STATUS_ARCHIVED:
				return 'Arquivada';
			default:
				return '';
		}
	}

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
}

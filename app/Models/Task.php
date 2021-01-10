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

    const STATUS_ACTIVE = 1;
	const STATUS_DONE = 2;
    
}

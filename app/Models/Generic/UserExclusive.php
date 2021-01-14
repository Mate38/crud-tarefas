<?php

namespace App\Models\Generic;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UserExclusive extends Model
{
	public static function boot()
	{
		parent::boot();

		static::addGlobalScope('userExclusive', function (Builder $builder) {
            $builder->where('user_id', auth()->user()->getAuthIdentifier());
        });

		static::saving(function ($model) {
			$model->user_id = auth()->user()->getAuthIdentifier();
		});
	}

}

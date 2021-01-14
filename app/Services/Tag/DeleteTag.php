<?php

namespace App\Services\Tag;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class DeleteTag
{
	protected $tag;

	public function __construct(Tag $tag)
    {
		$this->tag = $tag;
	}
	
	public function handle() {
		try {
			DB::beginTransaction();

				$this->tag->delete();

			DB::commit();
		} catch(\Exception $e) {
			DB::rollBack();
			abort(422, $e->getMessage());
		}
	}

}

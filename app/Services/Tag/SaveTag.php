<?php

namespace App\Services\Tag;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class SaveTag
{
	protected $formData;

	protected $tag;

	public function __construct(array $formData, Tag $tag = null)
    {
		$this->formData = $formData;
		$this->tag = $tag ?? new Tag();
	}
	
	public function handle() {
		try {
			DB::beginTransaction();

				$this->tag->fill($this->formData);
				$this->tag->save();

			DB::commit();
		} catch(\Exception $e) {
			DB::rollBack();
			abort(422, $e->getMessage());
		}
	}

}

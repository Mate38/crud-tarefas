<?php

namespace App\Services\Task;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class SaveTask
{
	protected $formData;

	protected $task;

	public function __construct(array $formData, Task $task = null)
    {
		$this->formData = $formData;
		$this->task = $task ?? new Task();
	}
	
	public function handle() {
		try {
			DB::beginTransaction();

				$this->task->fill($this->formData);
				$this->task->save();
				
				if($tags = data_get($this->formData, 'tags')) {
					$this->task->tags()->sync($tags);
				}
				
			DB::commit();
		} catch(\Exception $e) {
			DB::rollBack();
			abort(422, $e->getMessage());
		}
	}

}

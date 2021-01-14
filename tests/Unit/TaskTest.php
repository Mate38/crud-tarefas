<?php

namespace Tests\Unit;

use App\Models\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function test_task_creation()
    {
        $task = new Task([
            'cod' => 'cod',
            'title' => 'title',
            'description' => 'description',
            'status' => 1,
        ]);
    
        $this->assertEquals('cod', $task->cod);
        $this->assertEquals('title', $task->title);
        $this->assertEquals('description', $task->description);
        $this->assertEquals(1, $task->status);
    }
}

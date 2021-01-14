<?php

namespace Tests\Unit;

use App\Models\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function test_tag_creation()
    {
        $task = new Tag([
            'cod' => 'cod',
            'title' => 'title',
            'description' => 'description'
        ]);
    
        $this->assertEquals('cod', $task->cod);
        $this->assertEquals('title', $task->title);
        $this->assertEquals('description', $task->description);
    }
}

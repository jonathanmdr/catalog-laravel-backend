<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testListAll()
    {
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $expected = [
            'id',
            'name',
            'description',
            'is_active',
            'created_at',
            'updated_at',
            'deleted_at'
        ];
        $actual = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing($expected, $actual);
        $this->assertCount(1, $categories);
    }
}

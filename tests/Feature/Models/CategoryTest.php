<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
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

    public function testCreate()
    {
        $actual = Category::create([
            'name' => 'My Category Test'
        ]);
        $actual->refresh();
        $this->assertEquals('My Category Test', $actual->name);
        $this->assertNull($actual->description);
        $this->assertTrue($actual->is_active);

        $actual = Category::create([
            'name' => 'My Category Test',
            'description' => null
        ]);
        $this->assertNull($actual->description);

        $actual = Category::create([
            'name' => 'My Category Test',
            'description' => 'My Description Test'
        ]);
        $this->assertEquals('My Description Test', $actual->description);

        $actual = Category::create([
            'name' => 'My Category Test',
            'is_active' => false
        ]);
        $this->assertFalse($actual->is_active);

        $actual = Category::create([
            'name' => 'My Category Test',
            'is_active' => true
        ]);
        $this->assertTrue($actual->is_active);
    }

    public function testUpdate()
    {
        $category = factory(Category::class)->create([
            'description' => 'My Description Test',
            'is_active' => false
        ])->first();

        $expected = [
            'name' => 'My Name Updated',
            'description' => 'My Description Updated',
            'is_active' => true
        ];

        $category->update($expected);

        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }
    }
}

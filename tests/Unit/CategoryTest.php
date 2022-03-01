<?php

namespace Tests\Unit;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testIfUsingTraits()
    {
        $expected = [
            SoftDeletes::class,
            Uuid::class
        ];
        $actual = array_keys(class_uses(Category::class));
        $this->assertEquals($expected, $actual);
    }

    public function testFillableAttribute()
    {
        $category = new Category();
        $expected = ['name', 'description', 'is_active'];
        $this->assertEquals($expected, $category->getFillable());
    }

    public function testCastsAttribute()
    {
        $category = new Category();
        $expected = ['id' => 'string'];
        $this->assertEquals($expected, $category->getCasts());
    }

    public function testIncrementingAttribute()
    {
        $category = new Category();
        $this->assertFalse($category->incrementing);
    }

    public function testDatesAttribute()
    {
        $category = new Category();
        $expected = ['deleted_at', 'created_at', 'updated_at'];
        $actual = $category->getDates();
        foreach ($expected as $current) {
            $this->assertContains($current, $actual);
        }
        $this->assertCount(count($expected), $actual);
    }
}

<?php

namespace Tests\Unit\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    private $subject;

    protected function setup(): void
    {
        parent::setUp();
        $this->subject = new Category();
    }

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
        $expected = ['name', 'description', 'is_active'];
        $this->assertEquals($expected, $this->subject->getFillable());
    }

    public function testCastsAttribute()
    {
        $expected = ['id' => 'string'];
        $this->assertEquals($expected, $this->subject->getCasts());
    }

    public function testIncrementingAttribute()
    {
        $this->assertFalse($this->subject->incrementing);
    }

    public function testDatesAttribute()
    {
        $expected = ['deleted_at', 'created_at', 'updated_at'];
        $actual = $this->subject->getDates();
        foreach ($expected as $current) {
            $this->assertContains($current, $actual);
        }
        $this->assertCount(count($expected), $actual);
    }
}

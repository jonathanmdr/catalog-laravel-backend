<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Genre::class, 1)->create();
        $genres = Genre::all();
        $expected = [
            'id',
            'name',
            'is_active',
            'created_at',
            'updated_at',
            'deleted_at'
        ];
        $actual = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing($expected, $actual);
        $this->assertCount(1, $genres);
    }

    public function testCreate()
    {
        $actual = Genre::create([
            'name' => 'My Genre Test'
        ]);
        $actual->refresh();
        $this->assertTrue(RamseyUuid::isValid($actual->id));
        $this->assertEquals('My Genre Test', $actual->name);
        $this->assertNull($actual->description);
        $this->assertTrue($actual->is_active);

        $actual = Genre::create([
            'name' => 'My Genre Test',
        ]);
        $this->assertNull($actual->description);

        $actual = Genre::create([
            'name' => 'My Genre Test',
            'is_active' => false
        ]);
        $this->assertFalse($actual->is_active);

        $actual = Genre::create([
            'name' => 'My Genre Test',
            'is_active' => true
        ]);
        $this->assertTrue($actual->is_active);
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create([
            'is_active' => false
        ])->first();

        $expected = [
            'name' => 'My Name Updated',
            'is_active' => true
        ];

        $genre->update($expected);

        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create()->first();
        $this->assertNull($genre->deleted_at);
        
        $genre->delete();

        $this->assertNotNull($genre->deleted_at);
    }
}

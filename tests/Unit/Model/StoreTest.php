<?php

declare(strict_types=1);

namespace Tests\Unit\Model;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_to_array(): void
    {
        $store = Store::factory()->create()->fresh();

        $expectedKeys = [
            'id',
            'name',
            'slug',
            'user_id',
            'created_at',
            'updated_at',
        ];

        $this->assertEquals($expectedKeys, array_keys($store->toArray()));
    }
}

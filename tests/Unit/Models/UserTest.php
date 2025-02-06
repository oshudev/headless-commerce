<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Store;
use App\Models\User;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_to_array(): void
    {
        $user = User::factory()->create()->fresh();

        $expectedKeys = [
            'id',
            'store_id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
        ];

        $this->assertEquals($expectedKeys, array_keys($user->toArray()));
    }

    public function test_user_has_hidden_attributes(): void
    {
        $user = new User();

        $expectedHidden = ['password', 'remember_token'];

        $this->assertEqualsCanonicalizing($expectedHidden, $user->getHidden());
    }

    public function test_user_belongs_to_store(): void
    {
        $store = Store::factory()->create();
        $user = User::factory()->create(['store_id' => $store->id]);

        $this->assertTrue($user->store()->exists());
        $this->assertEquals($store->id, $user->store->id);
    }

    public function test_can_access_panel(): void
    {
        $user = User::factory()->create();
        $panel = $this->createMock(Panel::class);

        $this->assertTrue($user->canAccessPanel($panel));
    }

    public function test_get_default_tenant(): void
    {
        $store = Store::factory()->create();
        $user = User::factory()->create(['store_id' => $store->id]);
        $panel = $this->createMock(Panel::class);

        $this->assertInstanceOf(Model::class, $user->getDefaultTenant($panel));
        $this->assertEquals($store->id, $user->getDefaultTenant($panel)->id);
    }

    public function test_can_access_tenant(): void
    {
        $store = Store::factory()->create();
        $user = User::factory()->create(['store_id' => $store->id]);

        $this->assertTrue($user->canAccessTenant($store));

        $otherStore = Store::factory()->create();
        $this->assertFalse($user->canAccessTenant($otherStore));
    }

    public function test_get_tenants_returns_empty_array(): void
    {
        $user = User::factory()->create();
        $panel = $this->createMock(Panel::class);

        $this->assertIsArray($user->getTenants($panel));
        $this->assertEmpty($user->getTenants($panel));
    }
}

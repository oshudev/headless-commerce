<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('secret'),
            'email_verified_at' => Carbon::now(),
        ]);

        $store = Store::create([
            'name' => 'Acme',
            'slug' => 'acme',
            'user_id' => $user->id,
        ]);

        $user->store_id = $store->id;
        $user->save();
    }
}

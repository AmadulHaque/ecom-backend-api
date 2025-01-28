<?php

namespace Tests;

use App\Models\Merchant;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $user;

    public $merchant;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->merchant = Merchant::factory()->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user, 'sanctum');
        $this->seed(\Database\Seeders\ShopSettingSeeder::class);
    }
}

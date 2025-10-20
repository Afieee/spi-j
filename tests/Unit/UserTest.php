<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_checks_if_user_is_created()
    {
        // Membuat pengguna baru
        $user = User::factory()->create([
            'name' => 'Admin SPI',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password')
        ]);

        // Memeriksa apakah pengguna ada di database
        $this->assertDatabaseHas('users', [
            'email' => 'admin@gmail.com'
        ]);

        // Memeriksa apakah nama pengguna sesuai
        $this->assertEquals('Admin SPI', $user->name);
    }
}

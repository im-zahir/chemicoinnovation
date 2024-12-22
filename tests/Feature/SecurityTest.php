<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test CSRF protection
     */
    public function test_csrf_protection()
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Test message'
        ]);

        $response->assertStatus(419); // CSRF token mismatch
    }

    /**
     * Test XSS protection in form inputs
     */
    public function test_xss_protection()
    {
        $maliciousInput = '<script>alert("XSS")</script>';
        
        $response = $this->withoutExceptionHandling()
            ->post('/contact', [
                '_token' => csrf_token(),
                'name' => $maliciousInput,
                'email' => 'test@example.com',
                'message' => 'Test message'
            ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test SQL injection protection
     */
    public function test_sql_injection_protection()
    {
        $maliciousQuery = "'; DROP TABLE users; --";
        
        $response = $this->get('/products?search=' . $maliciousQuery);
        
        $response->assertStatus(200); // Should handle it safely
    }

    /**
     * Test password hashing
     */
    public function test_password_hashing()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertNotEquals('password123', $user->password);
    }

    /**
     * Test rate limiting on login attempts
     */
    public function test_login_rate_limiting()
    {
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ]);
        }

        $response->assertStatus(429); // Too Many Requests
    }

    /**
     * Test secure headers
     */
    public function test_security_headers()
    {
        $response = $this->get('/');

        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    /**
     * Test file upload security
     */
    public function test_file_upload_security()
    {
        $response = $this->post('/upload', [
            'file' => new \Illuminate\Http\UploadedFile(
                base_path('tests/fixtures/test.php'),
                'test.php',
                'application/x-php',
                null,
                true
            )
        ]);

        $response->assertSessionHasErrors('file');
    }

    /**
     * Test authentication routes protection
     */
    public function test_protected_routes()
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');

        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(200);
    }

    /**
     * Test password reset security
     */
    public function test_password_reset_security()
    {
        $user = User::factory()->create();

        $response = $this->post('/password/email', [
            'email' => $user->email
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $user->email
        ]);
    }

    /**
     * Test API authentication
     */
    public function test_api_authentication()
    {
        $response = $this->getJson('/api/user');
        $response->assertStatus(401);

        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/user');

        $response->assertStatus(200);
    }
}

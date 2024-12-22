<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'is_admin' => true,
        ]);
    }

    /** @test */
    public function admin_can_create_product()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('product.jpg');

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'category_id' => Category::factory()->create()->id,
            'image' => $file,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
        Storage::disk('public')->assertExists('products/' . $file->hashName());
    }

    /** @test */
    public function admin_can_create_category()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('category.jpg');

        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Test Category',
            'description' => 'Test Description',
            'image' => $file,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
        Storage::disk('public')->assertExists('categories/' . $file->hashName());
    }

    /** @test */
    public function admin_can_create_team_member()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('team.jpg');

        $response = $this->actingAs($this->admin)->post(route('admin.teams.store'), [
            'name' => 'John Doe',
            'position' => 'CEO',
            'image' => $file,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.teams.index'));
        $this->assertDatabaseHas('teams', ['name' => 'John Doe']);
        Storage::disk('public')->assertExists('team/' . $file->hashName());
    }

    /** @test */
    public function admin_can_create_testimonial()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('testimonial.jpg');

        $response = $this->actingAs($this->admin)->post(route('admin.testimonials.store'), [
            'client_name' => 'Jane Doe',
            'client_position' => 'CTO',
            'client_company' => 'Tech Corp',
            'content' => 'Great service!',
            'rating' => 5,
            'client_image' => $file,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonials', ['client_name' => 'Jane Doe']);
        Storage::disk('public')->assertExists('testimonials/' . $file->hashName());
    }

    /** @test */
    public function contact_form_submission_works()
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'subject' => 'Test Subject',
            'message' => 'Test Message',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /** @test */
    public function solution_pages_load_correctly()
    {
        $routes = [
            'solutions.industrial-chemicals',
            'solutions.laboratory-solutions',
            'solutions.custom-formulations',
            'solutions.safety-equipment',
            'solutions.quality-control',
            'solutions.rd-services',
        ];

        foreach ($routes as $route) {
            $response = $this->get(route($route));
            $response->assertStatus(200);
        }
    }
}

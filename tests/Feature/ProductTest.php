<?php

namespace Tests\Feature;

use App\Enums\RoleAndPermissionsEnum;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = User::factory()->create();

        $this->admin = User::factory()->create();
        $this->admin->assignRole(RoleAndPermissionsEnum::Role_Admin->value);
    }

    public function test_api_products_list_unauthenticated_user(): void
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(401);
    }

    public function test_api_products_list_none_admin_user(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/products');
        $response->assertStatus(403);
    }

    public function test_api_products_list(): void
    {
        $products = Product::factory(5)->create();
        $response = $this->actingAs($this->admin)->getJson('/api/products');

        $response->assertJson(['result' => true, 'data' => $products->toArray()]);
    }

    public function test_api_products_create_name_failed(): void
    {
        $product = [
            'name' => '',
            'cost' => '10000',
        ];

        $response = $this->actingAs($this->admin)->postJson('/api/products', $product);

        $response->assertJsonValidationErrors(['name'])
            ->assertStatus(422);

        $this->assertDatabaseMissing('products', $product);
    }

    public function test_api_products_create_cost_failed(): void
    {
        $product = [
            'name' => 'product_one',
            'cost' => 100,
        ];

        $response = $this->actingAs($this->admin)->postJson('/api/products', $product);

        $response->assertJson(['result' => false])
            ->assertStatus(400);

        $this->assertDatabaseMissing('products', $product);
    }

    public function test_api_products_create(): void
    {
        $product = [
            'name' => 'product_one',
            'cost' => 10000,
        ];

        $response = $this->actingAs($this->admin)->postJson('/api/products', $product);

        $response->assertJson(['result' => true])
            ->assertStatus(200);

        $this->assertDatabaseHas('products', $product);
    }

    public function test_api_products_show_wrong_id(): void
    {
        $productId = 1;

        $response = $this->actingAs($this->admin)->getJson('/api/products/'.$productId);

        $response->assertJson(['result' => false])
            ->assertStatus(404);
    }

    public function test_api_products_show(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)->getJson('/api/products/'.$product->id);

        $response->assertJson(['result' => true, 'data' => $product->toArray()])
            ->assertStatus(200);
    }

    public function test_api_products_update_wrong_id(): void
    {
        $productId = 1;

        $response = $this->actingAs($this->admin)->putJson('/api/products/'.$productId, []);

        $response->assertJson(['result' => false])
            ->assertStatus(404);
    }

    public function test_api_products_update(): void
    {
        $product = Product::factory()->create();

        $cost = $product->cost;

        $newCost = $cost * 10;

        $response = $this->actingAs($this->admin)->putJson('/api/products/'.$product->id, ['cost' => $newCost]);

        $product->cost = $newCost;

        $response->assertJson(['result' => true, 'data' => $product->toArray()])
            ->assertStatus(200);

        $this->assertDatabaseMissing('products', ['id' => $product->id, 'cost' => $cost])
            ->assertDatabaseHas('products', ['id' => $product->id, 'cost' => $newCost]);
    }

    public function test_api_products_delete_wrong_id(): void
    {
        $productId = 1;

        $response = $this->actingAs($this->admin)->deleteJson('/api/products/'.$productId);

        $response->assertJson(['result' => false])
            ->assertStatus(404);
    }

    public function test_api_products_delete(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)->deleteJson('/api/products/'.$product->id);

        $response->assertJson(['result' => true])
            ->assertStatus(200);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Product;
use App\Notifications\IngredientStockLow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Indicates whether the default seeder should run before each test.
     *
     * @var bool
     */
    protected $seed = true;

    public function test_orders_can_be_placed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('orders.store'), [
            'products' => [
                [
                    'product_id' => 1,
                    'quantity'   => 3
                ]
            ]
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('orders', ['user_id' => $user->id]);
    }

    public function test_ingredients_stock_is_reduced_when_orders_are_created(): void
    {
        $user    = User::factory()->create();
        $product = Product::with('ingredients')->first();

        $this->actingAs($user)->postJson(route('orders.store'), [
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity'   => 10
                ]
            ]
        ]);

        $product->fresh()->ingredients->each(function ($ingredient) use ($product) {
            $original = $product->ingredients->find($ingredient);
            $expected_stock_left = $original->stock - ($ingredient->pivot->quantity * 10);

            $this->assertEquals($expected_stock_left, $ingredient->stock);
        });
    }

    public function test_notification_is_sent_once_when_ingredient_stock_is_reduced_below_threshold(): void
    {
        Notification::fake();

        $ingredient = Ingredient::first();

        $ingredient->decrement('stock', $decrement = $ingredient->stock / 2);
        $ingredient->decrement('stock', $decrement /= 2);
        $ingredient->decrement('stock', $decrement / 2);

        Notification::assertSentOnDemandTimes(IngredientStockLow::class);
    }
}

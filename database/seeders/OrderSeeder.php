<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()
            ->has(ProductOrder::factory()->count(3), 'products')
            ->count(3)
            ->create([
                'user_id' => User::where('email', 'user@shop.ru')->first()->id,
            ]);

        Order::all()->each(function ($order) {
            $order->price = $order->products->reduce(function ($sum, $item) {
                return $sum + $item->product->price;
            });
            $order->save();
        });

    }
}

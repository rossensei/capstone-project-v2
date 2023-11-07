<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = [
            [
                'user_id' => mt_rand(1, User::where('id', '!=', 21)->count()),
                'req_date' => Carbon::now(),
                'status' => fake()->randomElement(['Pending', 'Accepted', 'Accepted', 'Accepted', 'Rejected']),
                'signature' => 'image/path/signature.png',
            ],
            [
                'user_id' => mt_rand(1, User::where('id', '!=', 21)->count()),
                'req_date' => Carbon::now(),
                'status' => fake()->randomElement(['Pending', 'Accepted', 'Accepted', 'Accepted', 'Rejected']),
                'signature' => 'image/path/signature.png',
            ],
            [
                'user_id' => mt_rand(1, User::where('id', '!=', 21)->count()),
                'req_date' => Carbon::now(),
                'status' => fake()->randomElement(['Pending', 'Accepted', 'Accepted', 'Accepted', 'Rejected']),
                'signature' => 'image/path/signature.png',
            ],
            [
                'user_id' => mt_rand(1, User::where('id', '!=', 21)->count()),
                'req_date' => Carbon::now(),
                'status' => fake()->randomElement(['Pending', 'Accepted', 'Accepted', 'Accepted', 'Rejected']),
                'signature' => 'image/path/signature.png',
            ],
            [
                'user_id' => mt_rand(1, User::where('id', '!=', 21)->count()),
                'req_date' => Carbon::now(),
                'status' => fake()->randomElement(['Pending', 'Accepted', 'Accepted', 'Accepted', 'Rejected']),
                'signature' => 'image/path/signature.png',
            ],
            [
                'user_id' => mt_rand(1, User::where('id', '!=', 21)->count()),
                'req_date' => Carbon::now(),
                'status' => fake()->randomElement(['Pending', 'Accepted', 'Accepted', 'Accepted', 'Rejected']),
                'signature' => 'image/path/signature.png',
            ],
        ];

        foreach($transactions as $data) {
            $req = Transaction::create($data);

            $numOfItems = fake()->randomElement(range(1,15)); //number of items to be added per request

            for($i = 1; $i <= $numOfItems; $i++) {

                $itemId = mt_rand(1, Item::count());
                $qty = mt_rand(1, 15);

                $req->items()->attach($itemId, [ 'qty' => $qty ]);

                $item = Item::find($itemId);

                $item->curr_stocks = $item->curr_stocks - $qty;

                $item->save();
            }
        }
    }
}

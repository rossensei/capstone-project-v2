<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Item;
// use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\FacultyRequest;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacultyRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $facultyRequest = [
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

        foreach($facultyRequest as $data) {
            $req = FacultyRequest::create($data);

            $numOfItems = fake()->randomElement(range(1,15)); //number of items to be added per request

            for($i = 1; $i <= $numOfItems; $i++) {

                $req->requestItems()->create([
                    'faculty_request_id' => $req->id,
                    'item_id' => mt_rand(1, Item::count()),
                    'req_qty' => mt_rand(1, 15),
                ]);
            }

        }
    }
}

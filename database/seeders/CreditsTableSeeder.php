<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Credit;

class CreditsTableSeeder extends Seeder
{
    public function run()
    {
        Credit::create(['member_id' => 1, 'allocated' => 2000, 'need' => 3000]);
        Credit::create(['member_id' => 2, 'allocated' => 4000, 'need' => 4000]);
        Credit::create(['member_id' => 3, 'allocated' => 7000, 'need' => 3000]);
    }
}

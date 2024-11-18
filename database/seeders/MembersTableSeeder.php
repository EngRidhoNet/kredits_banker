<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MembersTableSeeder extends Seeder
{
    public function run()
    {
        Member::create(['name' => 'John Doe', 'max_credit' => 5000]);
        Member::create(['name' => 'Jane Smith', 'max_credit' => 8000]);
        Member::create(['name' => 'Robert Brown', 'max_credit' => 10000]);
    }
}

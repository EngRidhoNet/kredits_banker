<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CreditStatus;

class CreditStatusesTableSeeder extends Seeder
{
    public function run()
    {
        CreditStatus::create(['available' => 15000]);
    }
}

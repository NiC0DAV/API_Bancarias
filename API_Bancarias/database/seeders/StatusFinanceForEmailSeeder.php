<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class StatusFinanceForEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fn_status_finance_for_email')->insert([
            'email' => 'approved@claro.com.co',
            'response_status' => true,
            'guaranteeRate' => 0,
            'causalRejection' => '',
        ]);

        DB::table('fn_status_finance_for_email')->insert([
            'email' => 'declined@claro.com.co',
            'response_status' => false,
            'guaranteeRate' => 0,
            'causalRejection' => 'The client is not valid for Finance',
        ]);

        DB::table('fn_status_finance_for_email')->insert([
            'email' => 'accept@claro.com.co',
            'response_status' => true,
            'guaranteeRate' => 20.0,
            'causalRejection' => '',
        ]);

        DB::table('fn_status_finance_for_email')->insert([
            'email' => 'guarantee@claro.com.co',
            'response_status' => true,
            'guaranteeRate' => 50.0,
            'causalRejection' => '',
        ]);

    }
}

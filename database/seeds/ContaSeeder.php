<?php

use Illuminate\Database\Seeder;

use App\Models\Conta;

class ContaSeeder extends Seeder
{
    public function run()
    {
        Conta::create(['conta' => 3535, 'saldo' => 523.22]);
        Conta::create(['conta' => 7201, 'saldo' => 10798.75]);
        Conta::create(['conta' => 2769, 'saldo' => 5720.89]);
    }
}

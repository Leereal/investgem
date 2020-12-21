<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Truncate the table.
        DB::table('banks')->truncate();
        Bank::create(['name'=>'BITCOIN','avatar'=>'bitcoin.png']);        
        Bank::create(['name'=>'PERFECT MONEY','avatar'=>'perfect_money.png']);
        Bank::create(['name'=>'SKRILL','avatar'=>'skrill.png']);
        Bank::create(['name'=>'NETELLER','avatar'=>'neteller.png']);
        Bank::create(['name'=>'EWALLET/CELLPHONE BANKING','avatar'=>'mobile_banking.png']);
        Bank::create(['name'=>'BANK TRANSFER','avatar'=>'fnb.png']);
       
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

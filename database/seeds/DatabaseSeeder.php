<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Smarch\Watchtower\Seeds\WatchtowerTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

//        factory(\App\User::class, 20)->create();
        factory(\App\Employee::class, 10)->create();
        factory(\App\Customer::class, 10)->create();
        factory(\App\Income::class, 10)->create();
        factory(\App\Expense::class, 10)->create();
        factory(\App\ExpenseCategory::class, 3)->create();
        factory(\App\IncomeCategory::class, 3)->create();
        factory(\App\Material::class, 10)->create();
        factory(\App\Measurement::class, 10)->create();
//        factory(\App\Document::class, 10)->create();
        factory(\App\Payment::class, 10)->create();
        factory(\App\Designation::class, 4)->create();
        factory(\App\ClotheType::class, 4)->create();
        factory(\App\Order::class, 10)->create();
        $this->call(WatchtowerTableSeeder::class);
        Model::reguard();
    }
}

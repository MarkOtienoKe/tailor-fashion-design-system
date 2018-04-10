<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'status' => 'ACTIVE',
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Customer::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'mobile' => $faker->phoneNumber,
        'id_number' => $faker->randomNumber(),
        'location' => $faker->streetName,
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});
$factory->define(App\Employee::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'mobile' => $faker->unique()->phoneNumber,
        'id_number' => $faker->unique()->randomNumber($nbDigits = 8),
        'address' => $faker->address,
        'designation_id' => 1,
        'salary' => $faker->randomFloat(),
        'date_of_employment' => '2017-07-18',
        'status' => 'ACTIVE',
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4
    ];
});
$factory->define(App\Designation::class, function (Faker\Generator $faker) {
    return [
        'designation_name' => $faker->unique()->jobTitle,
        'description' => $faker->paragraph(),
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});
$factory->define(App\Order::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->paragraph,
        'customer_id' => 1,
        'material_id' => 1,
        'clothe_type_id' => 1,
        'amount_to_pay' => $faker->randomFloat(),
        'amount_paid' => $faker->randomFloat(),
        'date_received' => $faker->unique()->date($format = 'Y-m-d', $max = 'now'),
        'date_of_collection' => $faker->unique()->date($format = 'Y-m-d', $max = 'now'),
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'NEW'
    ];
});
$factory->define(App\Expense::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->paragraph(),
        'expense_category_id' => 1,
        'amount' => $faker->randomFloat(),
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});
$factory->define(App\Payment::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->paragraph(),
        'amount' => $faker->randomFloat(),
        'order_id' => 1,
        'expense_id' => 1,
        'payment_type' => $faker->word,
        'payment_method' => $faker->word,
        'mpesa_transaction_id' => $faker->unique()->randomNumber(5),
        'date_of_payment' => $faker->unique()->date($format = 'Y-m-d', $max = 'now'),
        'added_by' => 1,
        'modified_by' => 1,
        'payment_document' => $faker->image(public_path(Config::get('assets.uploads/paymentDocuments')) ,800, 600, [], []),
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});
$factory->define(App\Income::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->paragraph,
        'income_category_id' => 1,
        'amount' => $faker->randomFloat(),
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});
$factory->define(App\ExpenseCategory::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->paragraph(),
        'name' => $faker->word,
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});
$factory->define(App\IncomeCategory::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->paragraph(),
        'name' => $faker->word,
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});
$factory->define(App\Material::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph(),
        'image' => $faker->image(public_path(Config::get('assets.images/materials')) ,800, 600, [], []),
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});
$factory->define(App\ClotheType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->paragraph(),
        'sex' => 'Male',
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});
$factory->define(App\Document::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->paragraph(),
        'document_type' => $faker->word,
        'document_name' => $faker->word,
        'document_file' => $faker->image(public_path(Config::get('assets.images/documents')) ,800, 600, [], []),
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});
$factory->define(App\Measurement::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->paragraph(),
        'length' => $faker->randomFloat(),
        'waist' => $faker->randomFloat(),
        'bottom' => $faker->randomFloat(),
        'thigh' => $faker->randomFloat(),
        'round' => $faker->randomFloat(),
        'fly' => $faker->randomFloat(),
        'shoulder' => $faker->randomFloat(),
        'sleeves' => $faker->randomFloat(),
        'chest' => $faker->randomFloat(),
        'tummy' => $faker->randomFloat(),
        'biceps' => $faker->randomFloat(),
        'round_sleeve' => $faker->randomFloat(),
        'burst' => $faker->randomFloat(),
        'hips' => $faker->randomFloat(),
        'bodies' => $faker->randomFloat(),
        'measurement_date' => '2018-01-24',
        'measurements_person_name' => $faker->name,
        'customer_id' => 1,
        'added_by' => 1,
        'modified_by' => 1,
        'ip_address' => $faker->unique()->ipv4,
        'status' => 'ACTIVE'
    ];
});



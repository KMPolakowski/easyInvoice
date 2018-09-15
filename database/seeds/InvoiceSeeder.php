<?php

use Illuminate\Database\Seeder;
// use Faker\Factory;
use App\Bank_detail;
use App\Contact_info;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    private $faker;

    public function run()
    {
        $this->faker = Faker\Factory::create('de_DE');

        factory(App\Invoice::class, 100)->create()->each(function ($val) {
            $bank_detail = new Bank_detail();
            $bank_detail->bank = $this->faker->bank;
            $bank_detail->bic = $this->faker->text(6);
            $bank_detail->iban = $this->faker->bankAccountNumber;
            $val->Bank_detail()->save($bank_detail);

            $contact = new Contact_info();
            $contact->tel = $this->faker->phoneNumber;
            $contact->email = $this->faker->email;
            $val->Contact_info()->save($contact);
        });
    }


    // $factory->define(App\Bank_detail::class, function (Faker $faker) {
    //     return [
    //         'bank' => $faker->name,
    //         'bic' => $faker->text(6),
    //         'iban' => $faker->bankAccountNumber
    //     ];
    // });
}

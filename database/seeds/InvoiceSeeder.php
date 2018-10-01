<?php

use Illuminate\Database\Seeder;
// use Faker\Factory;
use App\Bank_detail;
use App\Contact_info;
use App\Issuer;
use App\Item;
use App\Payment_condition;
use App\Receiver;
use App\User;
use App\Invoice;

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
        $this->faker = Faker\Factory::create('at_AT');

        for ($i1 = 0; $i1 < 20; $i1++) {
            $user = new User();
            $user->save();

            $this->faker = Faker\Factory::create('de_DE');
            $bank_detail = new Bank_detail();
            $bank_detail->bank = $this->faker->bank;
            $bank_detail->bic = $this->faker->text(6);
            $bank_detail->iban = $this->faker->bankAccountNumber;
            $this->faker = Faker\Factory::create('at_AT');

            $contact = new Contact_info();
            $contact->tel = $this->faker->phoneNumber;
            $contact->email = $this->faker->email;
            $contact->web = $this->faker->domainName;
            
            $issuer = new Issuer();
            $issuer->name = $this->faker->name;
            $issuer->street = $this->faker->streetName;
            $issuer->zip_code = $this->faker->postCode;
            $issuer->house_number = $this->faker->buildingNumber;
            $issuer->vat_number = $this->faker->vat(false);
            

            $user->Bank_detail()->save($bank_detail);
            $user->Contact_info()->save($contact);
            $user->Issuer()->save($issuer);

            for ($i2 = 1; $i2 < 21; $i2++) {
                $invoice = new Invoice();
                
                $invoice->date = $this->faker->date;
                $invoice->number = $i2;
                $invoice->topic = $this->faker->text($this->faker->numberBetween(8, 15));
                $invoice->street = $this->faker->streetName;
                $invoice->zip_code = $this->faker->postCode;
                $invoice->house_number = $this->faker->buildingNumber;
                $invoice->vat_percentage = $this->faker->numberBetween(15, 20);
                $invoice->draft = 0;
        
                
                $receiver = new Receiver();
                $receiver->name = $this->faker->name;
                $receiver->street = $this->faker->streetName;
                $receiver->zip_code = $this->faker->postCode;
                $receiver->house_number = $this->faker->buildingNumber;
                $this->faker->boolean ? $receiver->vat_number = $this->faker->vat(false): $receiver->vat_number = null;

                $receiver->save();
                $receiver->Invoice()->save($invoice);
    
                $netto_sum = 0;

                for ($i3 = 1; $i3 < $this->faker->numberBetween(1, 11); $i3++) {
                    $item = new Item();
                    $item->pos_num = $i3;
                    $item->descr = $this->faker->text($this->faker->numberBetween(15, 65));
                    $item->quantity = $this->faker->numberBetween(1, 15);
                    $item->price = $this->faker->randomFloat(2, 0, 10000);
                    $netto_sum =+ ($item->amount = round($item->price * $item->quantity, 2));
                    $invoice->Item()->save($item);
                    $user->Item()->save($item);
                }

                $invoice->netto_sum = $netto_sum;

                $vat_sum = $netto_sum * $invoice->vat_percentage;
                $invoice->vat_sum = $vat_sum;

                $invoice->brutto_sum = $netto_sum + $vat_sum;
    
                $payment = new Payment_condition();
                $payment->days = $this->faker->numberBetween(7, 60);
                $skonto = $this->faker->boolean;
                if ($skonto) {
                    $payment->has_skonto = $skonto;
                    $payment->days_skonto = round($payment->days/2, 0);
                    $payment->percent_skonto = $this->faker->numberBetween(1, 5);
                }
                $payment->save();

                $payment->Invoice()->save($invoice);
                $receiver->Invoice()->save($invoice);
                $bank_detail->Invoice()->save($invoice);
                $contact->Invoice()->save($invoice);
                $issuer->Invoice()->save($invoice);
                $user->Invoice()->save($invoice);
            }
        }
    }
}

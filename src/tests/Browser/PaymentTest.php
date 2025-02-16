<?php

namespace Tests\Browser;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PaymentTest extends DuskTestCase
{
    use DatabaseMigrations;
    public function test_purchase_payment()
    {
        $user=User::factory()->create();
        $item=Item::inRandomOrder()->first();

        $this->browse(function (Browser $browser) use ($user,$item){
            $browser->loginAs($user)
                    ->visitRoute('purchase.show',$item)
                    ->assertSee('支払い方法')
                    ->select('payment','コンビニ払い')
                    ->waitFor('.payment-result')
                    ->assertSeeIn('.payment-result','コンビニ払い')
                    ->select('payment', 'カード支払い')
                    ->waitFor('.payment-result')
                    ->assertSeeIn('.payment-result', 'カード支払い');
        });
    }
}

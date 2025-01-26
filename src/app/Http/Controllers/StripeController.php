<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Item;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function checkout(Item $item)
    {
        Stripe::setApiKey(config('stripe.stripe_secret_key'));

        $session = Session::create([
            'payment_method_types' => ['card', 'konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->item_name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('cancel'),
        ]);

        return redirect($session->url);
    }
}

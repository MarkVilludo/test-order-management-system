<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Token;
use Stripe\Customer;
use Stripe\Charge;

class PaymentService
{
    /**
     * PaymentService constructor.
     * Set the Stripe secret API key from your configuration.
     */
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Generate a Stripe token using card details.
     *
     * @param array $cardData Example:
     *   [
     *     'number'    => '4242424242424242',
     *     'exp_month' => 12,
     *     'exp_year'  => 2025,
     *     'cvc'       => '123'
     *   ]
     * @return \Stripe\Token
     */
    public function generateToken(array $cardData)
    {
        $token = Token::create([
            'card' => [
                'number'    => $cardData['number'],
                'exp_month' => $cardData['exp_month'],
                'exp_year'  => $cardData['exp_year'],
                'cvc'       => $cardData['cvc'],
            ],
        ]);

        return $token;
    }

    /**
     * Process a payment using a Stripe token.
     *
     * @param array $paymentData Example:
     *   [
     *     'amount'      => 49.99, // In dollars
     *     'currency'    => 'usd',
     *     'email'       => 'customer@example.com',
     *     'stripeToken' => 'tok_visa' // Or a token generated via generateToken()
     *   ]
     * @return \Stripe\Charge
     */
    public function processPayment(array $paymentData)
    {
        // Create a new Stripe customer using the token.
        $customer = Customer::create([
            'email'  => $paymentData['email'],
            'name'  => $paymentData['name'],
            'source' => $paymentData['stripeToken'],
        ]);

        // Create a charge for the customer.
        $charge = Charge::create([
            'customer' => $customer->id,
            'amount'   => $paymentData['amount'] * 100, // Stripe requires the amount in cents
            'currency' => $paymentData['currency'] ?? 'usd',
        ]);

        return $charge;
    }
}

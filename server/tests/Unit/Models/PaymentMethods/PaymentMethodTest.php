<?php

namespace Tests\Unit\Models\PaymentMethods;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    public function test_it_belongs_to_a_user()
    {
        $paymentMethod = factory(PaymentMethod::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertInstanceOf(User::class, $paymentMethod->user);
    }

    public function test_it_sets_old_payment_method_to_not_default_when_creating()
    {
        $user = factory(User::class)->create();

        $oldPaymentMethod = factory(PaymentMethod::class)->create([
            'default' => true,
            'user_id' => $user->id
        ]);

        factory(PaymentMethod::class)->create([
            'default' => true,
            'user_id' => $user->id
        ]);

        $this->assertFalse($oldPaymentMethod->fresh()->default);
    }
}

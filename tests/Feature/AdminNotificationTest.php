<?php

namespace Tests\Feature;

use App\Events\OrderPlaced;
use App\Listeners\NotifyAdmin;
use App\Listeners\SendInvoiceNotification;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NotifyAdminNotification;
use App\Notifications\SendInvoiceToCustomerNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdminNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_is_notified_when_new_order_is_placed(): void
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        Notification::assertNothingSent();

        $user = $this->place_order();
        Notification::assertCount(2);

        Notification::assertSentTo($user, SendInvoiceToCustomerNotification::class);
        Notification::assertSentTo(User::admin(), NotifyAdminNotification::class);

    }

    public function place_order()
    {
        $this->refreshDatabase();
        $user = $this->signIn();

        $product = Product::factory()->create();

        $response = $this->post(route('cart.store', $product));
        $response = $this->post(route('checkout.store'), [
            'terms' => 'true',
            'address' => 'a',
            'city' => 'b',
            'state' => 'c',
            'zip' => 'd',
            'country' => 'e',
        ]);
        return $user;
    }
}

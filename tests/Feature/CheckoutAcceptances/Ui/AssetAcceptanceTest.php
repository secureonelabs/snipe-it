<?php

namespace Tests\Feature\CheckoutAcceptances\Ui;

use App\Events\CheckoutAccepted;
use App\Models\CheckoutAcceptance;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AssetAcceptanceTest extends TestCase
{
    public function testAssetCheckoutAcceptPageRenders()
    {
        $checkoutAcceptance = CheckoutAcceptance::factory()->pending()->create();

        $this->actingAs($checkoutAcceptance->assignedTo)
            ->get(route('account.accept.item', $checkoutAcceptance))
            ->assertViewIs('account.accept.create');
    }

    public function testCannotAcceptAssetAlreadyAccepted()
    {
        Event::fake([CheckoutAccepted::class]);

        $checkoutAcceptance = CheckoutAcceptance::factory()->accepted()->create();

        $this->assertFalse($checkoutAcceptance->isPending());

        $this->actingAs($checkoutAcceptance->assignedTo)
            ->post(route('account.store-acceptance', $checkoutAcceptance), [
                'asset_acceptance' => 'accepted',
                'note' => 'my note',
            ])
            ->assertRedirectToRoute('account.accept')
            ->assertSessionHas('error');

        Event::assertNotDispatched(CheckoutAccepted::class);
    }

    public function testCannotAcceptAssetForAnotherUser()
    {
        Event::fake([CheckoutAccepted::class]);

        $checkoutAcceptance = CheckoutAcceptance::factory()->pending()->create();

        $this->assertTrue($checkoutAcceptance->isPending());

        $anotherUser = User::factory()->create();

        $this->actingAs($anotherUser)
            ->post(route('account.store-acceptance', $checkoutAcceptance), [
                'asset_acceptance' => 'accepted',
                'note' => 'my note',
            ])
            ->assertRedirectToRoute('account.accept')
            ->assertSessionHas('error');

        $this->assertTrue($checkoutAcceptance->fresh()->isPending());

        Event::assertNotDispatched(CheckoutAccepted::class);
    }

    public function testUserCanAcceptAssetCheckout()
    {
        Event::fake([CheckoutAccepted::class]);

        $checkoutAcceptance = CheckoutAcceptance::factory()->pending()->create();

        $this->assertTrue($checkoutAcceptance->isPending());

        $this->actingAs($checkoutAcceptance->assignedTo)
            ->post(route('account.store-acceptance', $checkoutAcceptance), [
                'asset_acceptance' => 'accepted',
                'note' => 'my note',
            ])
            ->assertRedirectToRoute('account.accept')
            ->assertSessionHas('success');

        $this->assertFalse($checkoutAcceptance->fresh()->isPending());

        Event::assertDispatched(CheckoutAccepted::class);
    }

    public function testActionLoggedWhenAcceptingAsset()
    {
        $this->markTestIncomplete();
    }
}

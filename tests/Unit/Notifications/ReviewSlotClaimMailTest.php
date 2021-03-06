<?php

namespace Tests\Unit\Notifications;

use App\Models\Slot;
use App\Models\User;
use App\Notifications\ReviewSlotClaimNotification;
use Tests\TestCase;

class ReviewSlotClaimMailTest extends TestCase
{
    /** @test */
    public function it_can_render_the_review_slot_claim_notification_to_mail()
    {
        $user = factory(User::class)->create();

        $slot = factory(Slot::class)->create();

        $notification = (new ReviewSlotClaimNotification($user, $slot));

        $this->assertNotNull($this->getHtmlForNotificationMail($notification, $user));
    }
}

<?php

use App\Http\Front\Controllers\EventAdmin\EventsController;
use App\Http\Front\Controllers\EventAdmin\SlotsController;
use App\Http\Front\Controllers\EventAdmin\TracksController;
use App\Http\Front\Controllers\Events\AttendEventController;
use App\Http\Front\Controllers\Events\DoNotAttendEventController;
use App\Http\Front\Controllers\Events\PastEventsListController;
use App\Http\Front\Controllers\Events\RecentAndUpcomingEventsListController;
use App\Http\Front\Controllers\Events\ShowEventFeedbackController;
use App\Http\Front\Controllers\Events\ShowEventScheduleController;
use App\Http\Front\Controllers\Events\SpeakingAtEventsListController;
use App\Http\Front\Controllers\ReviewsController;
use App\Http\Front\Controllers\SlotOwnershipClaims\ApproveSlotOwnershipClaimController;
use App\Http\Front\Controllers\SlotOwnershipClaims\RejectSlotOwnershipClaimController;
use App\Http\Front\Controllers\Slots\ClaimSlotController;
use App\Http\Front\Controllers\Slots\ShowSlotController;
use App\Http\Front\Controllers\UsersController;
use App\Models\Event;
use App\Models\Slot;

Route::get('/', RecentAndUpcomingEventsListController::class);
Route::get('past-events', PastEventsListController::class);
Route::get('speaking', SpeakingAtEventsListController::class)->middleware('auth');

Route::prefix('organizing')->middleware('auth')->group(function () {
    Route::get('/', [EventsController::class, 'index']);
    Route::get('create', [EventsController::class, 'create'])->name('event-admin.events.create');
    Route::post('create', [EventsController::class, 'store'])->name('event-admin.events.store');
    Route::get('events/{event}', [EventsController::class, 'edit'])->name('event-admin.events.edit');
    Route::post('events/{event}', [EventsController::class, 'update'])->name('event-admin.events.update');

    Route::get('events/{event}/tracks', [TracksController::class, 'index'])->name('event-admin.tracks');
    Route::get('events/{event}/slots', [SlotsController::class, 'index'])->name('event-admin.slots');
});

Route::prefix('/events/{event}')->group(function () {
    Route::get('/', function (Event $event) {
        return redirect()->route('events.show-schedule', $event->idSlug());
    });
    Route::get('schedule', ShowEventScheduleController::class)->name('events.show-schedule');
    Route::get('feedback', ShowEventFeedbackController::class)->name('events.show-feedback');
    Route::post('attend', AttendEventController::class);
    Route::post('do-not-attend', DoNotAttendEventController::class);
});

Route::get('slots/{slot}', ShowSlotController::class)->name('slots.show');
Route::post('slots/{slot}/claim', ClaimSlotController::class)->name('slots.claim');

Route::prefix('slot-ownership-claims/{slotOwnershipClaim}')->group(function () {
    Route::post('approve', ApproveSlotOwnershipClaimController::class)->name('slot-ownership-claims.approve');
    Route::post('reject', RejectSlotOwnershipClaimController::class)->name('slot-ownership-claims.reject');
});

Route::prefix('reviews')->group(function () {
    Route::post('/', [ReviewsController::class, 'store'])->name('reviews.store');
    Route::delete('{review}', [ReviewsController::class, 'delete'])->name('reviews.delete');
});

Route::get('users/{user}', [UsersController::class, 'show'])->name('users.show');

Route::get('{slotShortSlug}', function (Slot $slot) {
    return redirect()->route('slots.show', $slot->idSlug());
})->where(['slotShortSlug' => '[a-zA-Z0-9]{6}']);

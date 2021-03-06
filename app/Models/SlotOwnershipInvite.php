<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SlotOwnershipInvite extends BaseModel
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }
}

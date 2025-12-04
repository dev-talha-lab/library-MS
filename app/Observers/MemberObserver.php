<?php

namespace App\Observers;

use App\Models\Member;
use Illuminate\Support\Str;

class MemberObserver
{
    /**
     * Handle the Member "created" event.
     */
    public function created(Member $member): void
    {
        if (!$member->membership_id) {
            $prefix = 'MBR-'.Str::upper(Str::random(4)).'-'.$member->id;
            $member->membership_id = $prefix;
            $member->saveQuietly();
        }
    }

    /**
     * Handle the Member "updated" event.
     */
    public function updated(Member $member): void
    {
        //
    }

    /**
     * Handle the Member "deleted" event.
     */
    public function deleted(Member $member): void
    {
        $hasActive = $member->borrowRecords()->whereNull('returned_at')->exists();
        if ($hasActive) {
            throw new \Exception("Member has active borrows and cannot be deleted.");
        }
    }

    /**
     * Handle the Member "restored" event.
     */
    public function restored(Member $member): void
    {
        //
    }

    /**
     * Handle the Member "force deleted" event.
     */
    public function forceDeleted(Member $member): void
    {
        //
    }
}

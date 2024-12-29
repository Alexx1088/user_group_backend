<?php

namespace App\Observers;

use App\Models\GroupUser;
use Illuminate\Support\Facades\DB;

class GroupUserObserver
{
    /**
     * Handle the GroupUser "created" event.
     */
    public function created(GroupUser $groupUser): void
    {
        //Retrieve the group's expire_hours
        $group = DB::table('group')
            ->where('id', $groupUser->group_id)->first();

        if ($group) {
            // Set expired_at based on expire_hours
            $groupUser->expired_at = now()->addHours($group->expire_hours);

            $groupUser->save();
        }

    }

    /**
     * Handle the GroupUser "updated" event.
     */
    public function updated(GroupUser $groupUser): void
    {
        //
    }

    /**
     * Handle the GroupUser "deleted" event.
     */
    public function deleted(GroupUser $groupUser): void
    {
        //
    }

    /**
     * Handle the GroupUser "restored" event.
     */
    public function restored(GroupUser $groupUser): void
    {
        //
    }

    /**
     * Handle the GroupUser "force deleted" event.
     */
    public function forceDeleted(GroupUser $groupUser): void
    {
        //
    }
}

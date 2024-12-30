<?php

namespace App\Observers;

use App\Models\GroupUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GroupUserObserver
{
    public function creating(GroupUser $groupUser): void
    {
        $group = DB::table('groups')

            ->where('id', $groupUser->group_id)->first();

        if ($group) {

            $groupUser->expired_at = Carbon::now()->addHours($group->expire_hours);

        }

    }

}

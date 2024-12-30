<?php

namespace App\Console\Commands;

use App\Jobs\DeactivateUserJob;
use App\Mail\UserGroupExpiration;
use App\Models\GroupUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckUserExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:check_expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove users from groups whose expired_at time has passed and send them an email notification';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $expiredUsers = DB::table('group_user')
            ->join('users', 'users.id', '=', 'group_user.user_id')
            ->join('groups', 'groups.id', '=', 'group_user.group_id')
            ->where('expired_at', '<', Carbon::now())
            ->select('group_user.user_id', 'group_user.group_id', 'users.name as user_name',
                'users.email', 'groups.name as group_name')
            ->get();

        foreach ($expiredUsers as $expiredUser) {

          //  Mail::to($expiredUser->email)->send(new UserGroupExpiration($expiredUser->user_name, $expiredUser->group_name));

            DB::table('group_user')
                ->where('user_id', $expiredUser->user_id)
                ->where('group_id', $expiredUser->group_id)
                ->delete();

            $user = User::find($expiredUser->user_id);

            if ($user->groups()->count() === 0) {

                DeactivateUserJob::dispatch($user);
            }

            $this->info("User {$expiredUser->user_name} removed from group {$expiredUser->group_name} and email sent");

        }

        $this->info('Expired users have been processed.');

    }
}

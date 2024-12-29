<?php

namespace App\Console\Commands;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Console\Command;

class AddUserToGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:member';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a user to a group and activate the user if inactive';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $userId = $this->ask('Enter the user ID');

        $groupId = $this->ask('Enter the group ID');

        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found');
            return 1;
        }

        $group = Group::find($groupId);

        if (!$group) {
            $this->error('Group not found');
            return 1;
        }

        if (!$user->active) {
            $user->update(['active' => true]);
            $this->info('User activated');
        }

        GroupUser::create([
            'user_id' => $userId,
            'group_id' => $groupId
        ]);

        $this->info('User added to the group successfully.');

        return 0;
    }
}

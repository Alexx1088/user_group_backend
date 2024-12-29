<?php

namespace App\Console\Commands;

use App\Models\GroupUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
    protected $description = 'Remove users from groups where expired_at is less than the current time';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        DB::table('group_user')
            ->where('expired_at', '<', now())
            ->delete();

        $this->info('Expired users have been removed from groups.');
    }
}

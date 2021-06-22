<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoCancelVip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vip:auto_cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto cancel user VIP';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Start cancel vip job');
        $users = User::where('type_user', User::TYPE_VIP_USER)->whereDate('vip_end_date', date('Y-m-d'))->get();
        foreach($users as $user) {
            User::where('id', $user->id)->update(['type_user' => User::TYPE_NORMAL_USER]);
        }
        Log::info('End cancel vip job');
        return 0;
    }
}

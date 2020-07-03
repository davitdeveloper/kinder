<?php

namespace App\Console\Commands;

use App\Models\Rate;
use App\Models\User;
use App\Models\UserChildren;
use App\Notifications\ChildrenBirthdayMail;
use App\Notifications\OfferMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class ChildrenBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'children:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Coming birthdays';

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
     * @return mixed
     */
    public function handle()
    {
        $childrens = UserChildren::where('birthday','<',Carbon::now() -> addDay(3))
            ->where('birthday','>',Carbon::now())
            ->with(['user'])
            ->get();
        $fromUser = User::findOrFail(1);

        foreach ($childrens as $children){
            $toUser = $children->user;
            Notification::send($toUser, new ChildrenBirthdayMail($fromUser,$children));
        }

        dd($childrens);
    }
}

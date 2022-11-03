<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class MeetingReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:meeting-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $data = Booking::where("meeting_attended",false)->get();
        app()->call('App\Http\Controllers\VideoSDKController@MeetingCreate');
//
//        $controller = app()->make('App\Http\Controllers\VideoSDKController');
//# now let's call the method, inside the container, method name is 'getNewsByCatId'
//        app()->call([$controller, 'MeetingCreate']);
//        dd($data) ;
    }
}

<?php

namespace App\Console\Commands;

use App\Models\CartOrder;
use App\Models\Meeting;
use Illuminate\Console\Command;
use App\Models\Mtn;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Delights\Mtn\Products\Collection;

class UpdateDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update weekly meetings';

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
        $meetings = Meeting::where('frequency','Weekly')->get();
           
        foreach($meetings as $meeting){
            $next_start_time = $meeting->start_time->addDays(7)->toDateTimeString();
            $next_end_time = $meeting->end_time->addDays(7)->toDateTimeString();
            $updated = $meeting->update([
                  'start_time' => $next_start_time,
                  'end_time' => $next_end_time,
            ]);
        }
    }
}

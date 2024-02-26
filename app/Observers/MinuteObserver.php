<?php

namespace App\Observers;

use App\Models\Minute;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MinuteObserver
{
    /**
     * Handle the Minute "created" event.
     *
     * @param  \App\Models\Minute  $minute
     * @return void
     */
    public function creating(Minute $minute)
    {
        $minute->access_password =  Str::random(20);
        $minute->week_no = Carbon::now()->weekOfYear;
    }

    /**
     * Handle the Minute "updated" event.
     *
     * @param  \App\Models\Minute  $minute
     * @return void
     */
    public function updated(Minute $minute)
    {
        //
    }

    /**
     * Handle the Minute "deleted" event.
     *
     * @param  \App\Models\Minute  $minute
     * @return void
     */
    public function deleted(Minute $minute)
    {
        //
    }

    /**
     * Handle the Minute "restored" event.
     *
     * @param  \App\Models\Minute  $minute
     * @return void
     */
    public function restored(Minute $minute)
    {
        //
    }

    /**
     * Handle the Minute "force deleted" event.
     *
     * @param  \App\Models\Minute  $minute
     * @return void
     */
    public function forceDeleted(Minute $minute)
    {
        //
    }
}

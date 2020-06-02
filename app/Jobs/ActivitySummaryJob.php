<?php

namespace App\Jobs;

use App\Mail\ActivitySummaryMail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use League\Flysystem\Config;
use Spatie\GoogleCalendar\Event;

class ActivitySummaryJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return boolean
     */
    public function handle()
    {
        $from = Carbon::now()->startOfMonth()->subMonth();
        $to = Carbon::now()->endOfMonth()->subMonth();

        $monthlyEvents = Event::get($from, $to)->groupBy(function($event) {
            return $event->googleEvent->summary;
        });;

        $topMonthlyEvents = $monthlyEvents->map(function ($event) {
            return collect($event)->map(function($task) {
                return Carbon::parse($task->start->dateTime)->diffInMinutes($task->end->dateTime) / 60;
            })->sum();
        })->sort()->reverse();

        if($topMonthlyEvents) {
            Mail::to(env('APP_EMAIL_TO'))->send(new ActivitySummaryMail($topMonthlyEvents));
            return true;
        }

        return false;
    }
}

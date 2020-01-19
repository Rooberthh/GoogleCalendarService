<?php


    namespace App\Http\Controllers;
    use Carbon\Carbon;
    use Spatie\GoogleCalendar\Event;



    class TopWeeklyEventsController
    {
        public function index()
        {
            $weeklyEvents = Event::get(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek())->groupBy(function($event) {
                return $event->googleEvent->summary;
            });

            $topEvents = $weeklyEvents->map(function ($event) {
                return collect($event)->map(function($task) {
                    return Carbon::parse($task->start->dateTime)->diffInMinutes($task->end->dateTime);
                })->sum();
            })->sort()->reverse()->take(5);

            return $topEvents;
        }

    }

<?php

    namespace App\Http\Controllers;

    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Spatie\GoogleCalendar\Event;

    class FrequentEventsController extends Controller
    {

        /**
         * @return \Illuminate\Support\Collection
         */
        public function index()
        {
            $firstOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $events = Event::get($firstOfMonth, $endOfMonth)->groupBy(function($event) {
                return $event->googleEvent->summary;
            });

            $frequentEvents = $events->map(function ($item, $key) {
                return collect($item)->count();
            })->sort()->reverse();

            $temp = [];
            foreach($frequentEvents as $key => $value ) {
                array_push($temp, $key);
            }
            return collect($temp)->take(5);
        }
    }

<?php

    namespace App\Http\Controllers;

    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Spatie\GoogleCalendar\Event;

    class EventsController extends Controller
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            //
        }

        public function index()
        {
            $today = Carbon::now();
            $from = null;
            $to = null;

            if($today->dayOfWeek == Carbon::SUNDAY){
                $from = Carbon::now()->startOfDay();
                $to = Carbon::now()->addWeek()->endOfWeek();
            } else {
                $from = Carbon::now()->startOfWeek()->subDay();
                $to = Carbon::now()->endOfWeek()->subDay();
            }

            return Event::get($from, $to);
        }

        public function store(Request $request)
        {
            $this->validate($request, [
                'name' => 'required',
                'startDateTime' => 'required',
                'endDateTime' => 'required',
            ]);

            $event = Event::create([
                'name' => $request->get('name'),
                'startDateTime' => Carbon::parse($request->get('startDateTime')),
                'endDateTime' => Carbon::parse($request->get('endDateTime')),
            ]);

            return response(json_encode($event), 201);
        }

        public function update(Request $request, $id)
        {
            $this->validate($request, [
                'name' => 'required',
                'startDateTime' => 'required',
                'endDateTime' => 'required',
            ]);

            $event = Event::find($id);

            $event = $event->update([
                'name' => $request->get('name'),
                'startDateTime' => Carbon::parse($request->get('startDateTime')),
                'endDateTime' => Carbon::parse($request->get('endDateTime'))
            ]);

            return response(json_encode($event), 200);
        }

        public function destroy($id)
        {
            $event = Event::find($id);
            $event->delete();

            return response("Event have been deleted", 204);
        }
    }

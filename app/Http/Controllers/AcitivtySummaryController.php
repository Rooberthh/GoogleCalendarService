<?php

    namespace App\Http\Controllers;

    use App\Jobs\ActivitySummaryJob;

    class AcitivtySummaryController extends Controller
    {
        /**
         * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory|string
         */
        public function index()
        {
            $job = $this->dispatch(new ActivitySummaryJob);
            if($job == 0) {
                return response('Job executed', 200);
            }
            return "something went wrong";
        }
    }

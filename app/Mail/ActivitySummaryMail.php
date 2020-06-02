<?php


    namespace App\Mail;


    use Illuminate\Bus\Queueable;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class ActivitySummaryMail extends Mailable
    {
        use Queueable,
            SerializesModels;
        public $events;

        public function __construct($events)
        {
            $this->events = $events;
        }

        //build the message.
        public function build() {
            return $this->markdown('emails.activity-summary')->with(['events' => $this->events]);
        }
    }

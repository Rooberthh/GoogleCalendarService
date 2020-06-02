@component('mail::message')
    # Activity summary:

    @foreach($events as $name => $value)
    {{ $name }}: {{ $value }}
    @endforeach

    Thanks, {{ config('app.name') }}
@endcomponent

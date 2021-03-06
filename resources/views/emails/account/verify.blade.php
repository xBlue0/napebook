@component('mail::layout')

@slot('header')
    @component('mail::header', ['url' => route('index')])
        {{ config('app.name') }}
    @endcomponent
@endslot

# Ciao {{ $name }}!

Grazie per esserti registrato a Napebook. Clicca sul pulsante qui in basso per confermare il tuo account e cominciare a navigare.

@component('mail::button', ['url' => route('verify', $token)])
    Accedi
@endcomponent

A presto,<br>
Il team di {{ config('app.name') }}

@slot('footer')
    @component('mail::footer')
        © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endslot

@endcomponent

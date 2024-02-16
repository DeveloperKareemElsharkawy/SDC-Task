@component('mail::message')
    # مرحباً بك في تطبيقنا

    مرحباً {{ $user->name }} ،

    نرحب بك في تطبيقنا! نحن متحمسون لاستقبالك في فريقنا.

    شكراً لانضمامك لنا.

    تحياتنا،
    {{ config('app.name') }}
@endcomponent

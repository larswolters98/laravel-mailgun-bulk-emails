<x-mail::message>
{{-- You can access the data given to the Mailgun recipients using %recipient.<key>% --}}
Dear %recipient.name%.

This is the example content of the example notification. For more information, click the button below.

{{-- Data passed to the notification class can be accessed as normal --}}
<x-mail::button url="{{ $url }}">
More information
</x-mail::button>
</x-mail::message>

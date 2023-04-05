<x-mail::message>
    # Congratulations! You just purchased {{ count($videos) }} video{{ count($videos) > 1 ? "s" : "" }}.

Thank you for supporting Kenyan artists, here's your receipt.

<x-mail::panel>
        @foreach($videos as $video)
            {{ $video['name'] }}<br>
            {{ $video['username'], $video['ft'] }}<br><br>
        @endforeach
</x-mail::panel>

<x-mail::button :url="'https://music.black.co.ke/library'">
        CHECK THEM OUT
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

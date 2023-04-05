<x-mail::message>
# Congratulations! You just purchased {{ count($audios) }} audio{{ count($audios) > 1 ? "s" : "" }} at a cost of KES {{ count($audios) * 10 }}.

Thank you for supporting Kenyan artists, here's your receipt.

<x-mail::panel>
	@foreach($audios as $audio)
	    {{ $audio['name'] }}<br>
	    {{ $audio['username'], $audio['ft'] }}<br><br>
	@endforeach
</x-mail::panel>

<x-mail::button :url="'https://music.black.co.ke/library'">
CHECK THEM OUT
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

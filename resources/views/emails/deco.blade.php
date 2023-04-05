<x-mail::message>
# Congratulations {{ $username }}, {{ $artist }} just decorated you!

{{ $artist }} decorated you because you bought 10 of his videos/audios.
Users receive 1 deco for every 10 items they buy from a musician.

<x-mail::button :url="''">
CHECK OUT {{ $artist }}
</x-mail::button>

Keep it up,<br>
Black Music.
</x-mail::message>

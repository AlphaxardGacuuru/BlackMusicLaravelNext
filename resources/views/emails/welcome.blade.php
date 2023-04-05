@component('mail::message')
# Welcome {{$username}} to Black Music

Thanks for singing up! You've just joined the best online music store in Kenya. As a user you'll be able to;
<ul>
	<li>Follow your favourite musicians.</li>
	<li>Buy their videos and audios.</li>
	<li>Sell your own videos and audios.</li>
</ul>

and much more! To get you started checkout our awesome songs.

@component('mail::button', ['url' => $url, 'color' => "primary"])
CHECK THEM OUT
@endcomponent

Thank you and we're excited to have you!<br>

Alphaxard Gacuuru,<br>
Founder, Black Music.
@endcomponent
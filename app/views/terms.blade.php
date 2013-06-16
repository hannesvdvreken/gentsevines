@include('_parts.header')
@include('_parts.nav')

	<div class="row first">
		<div class="large-4 large-centered columns terms">
			<img src="{{ URL::to('/assets/img/homo.jpg') }}">
		</div>
	</div>
	<div class="row">
		<div class="large-8 large-centered columns terms">
			<h2>
				Oyoyeah!
			</h2>
			<p>
				Kijkt ne keer hier wa da der hier allemaal opstaat zeg. Funny filmkes, Funny mensen, alles is hier Funny! Gent, da's toch een kweet-nie-hoe wijze stad?!
			</p><p>
				(Om een clip te starten, klik op de afbeelding. Klikken om weer te stoppen.)
			</p>

			<h2>
				Voorwaarden en referenties
			</h2>
			<p>
				Dit is een onofficiële applicatie die gebruikt maakt van een onoffiële connectie met Vine. De inspiratie komt van <a href="https://github.com/neuegram/vino/commit/f7b559bf0eefe2675add7208741ea76b941ff48f" target="_blank">documentatie</a> gevonden op <a href="https://github.com" target="_blank">Github</a>. Alle clips zijn afkomstig van gebruikers van Vine en <a href="http://www.vine.co/terms" target="_blank">hun verantwoordelijkheid</a>. Gebruikte logo's zijn eigendom van Vine. De foto van <a href="http://www.vier.be/istnogver/tags/homo-turisticus" target="_blank">Homo Turisticus</a> bovenaan deze pagina is uiteraard eigendom van <a href="http://www.vier.be" target="_blank">Vier<a>.
			</p><p>
				De uitwisseling van gegevens gebeurt anoniem en zal niet gebruikt worden voor commerciële doeleinden. Wachtwoorden die gebruikers invullen op het <a href="{{ URL::to('/login/vine')}}">loginscherm</a> worden <i>nooit</i> bijgehouden, en slechts <i>één keer</i> gebruikt om een authenticatie te verkrijgen met <a href="https://vine.co" target="_blank">vine.co</a>
			</p><p>
				Gebruikte hulpmiddelen bij het creëren van <a href="http://gentsevines.be">gentsevines.be</a>: Nginx, PHP, Git, Sass, CSS3, HTML5, Zepto.js (performante replacement voor JQuery), Foundation 4, Laravel 4, Fontawesome, Modernizr en Icanhaz.js.
			</p>
		</div>
	</div>

@include('_parts.footer')
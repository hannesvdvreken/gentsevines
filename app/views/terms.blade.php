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
				Hoe het net werkt: om een clip te starten, klik op de afbeelding. Opnieuw klikken om weer te stoppen.
			</p>

			<h2>
				Voorwaarden en referenties
			</h2>
			<p>
				Dit is een onofficiële applicatie die gebruikt maakt van een onoffiële connectie met Vine. De inspiratie komt van <a href="https://github.com/neuegram/vino/commit/f7b559bf0eefe2675add7208741ea76b941ff48f" target="_blank">documentatie</a> gevonden op <a href="https://github.com" target="_blank">Github</a>. Alle clips zijn afkomstig van gebruikers van Vine en <a href="http://www.vine.co/terms" target="_blank">hun verantwoordelijkheid</a>. Gebruikte logo's zijn eigendom van Vine. De foto van <a href="http://www.vier.be/istnogver/tags/homo-turisticus" target="_blank">Homo Turisticus</a> bovenaan deze pagina is uiteraard eigendom van <a href="http://www.vier.be" target="_blank">Vier<a>.
			</p><p>
				De uitwisseling van gegevens gebeurt anoniem en verzamelde gegevens zullen niet worden misgebruikt voor commerciële doeleinden. Wachtwoorden die gebruikers invullen op het <a href="{{ URL::to('/login/vine')}}">loginscherm</a> worden <i>nooit</i> bijgehouden, en slechts <i>één keer</i> gebruikt om een authenticatie te verkrijgen met <a href="https://vine.co" target="_blank">vine.co</a>
			</p><p>
				Gebruikte hulpmiddelen bij het creëren van <a href="http://gentsevines.be">gentsevines.be</a>: <a href="http://nginx.com/" target="_blank">Nginx</a>, <a href="http://php.net/" target="_blank">PHP</a>, <a href="http://git-scm.com/" target="_blank">Git</a>, <a href="http://sass-lang.com/" target="_blank">Sass</a>, <a href="http://www.css3.info/" target="_blank">CSS3</a>, <a href="http://dev.w3.org/html5/spec/" target="_blank">HTML5</a>, <a href="http://zeptojs.com/" target="_blank">Zepto.js</a> (performante replacement voor JQuery), <a href="http://foundation.zurb.com/" target="_blank">Foundation 4</a>, <a href="http://laravel.com/" target="_blank">Laravel 4</a>, <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Fontawesome</a> en <a href="http://icanhazjs.com/" target="_blank">Icanhaz.js</a>.
			</p>
			<h2>Contact</h2>
			<p>Contact opnemen? Via <a href="mailto:vandevreken.hannes+gv@gmail.com">mail</a> of <a href="https://twitter.com/hannesvdvreken">twitter</a></p>
		</div>
	</div>

@include('_parts.footer')
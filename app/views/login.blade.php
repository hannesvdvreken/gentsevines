@include('_parts.header')

	<div class="row first">
		<div class="large-8 large-centered columns">
			<h1>
				login 
			</h1>
			<h2>
				<small>
					gebruik je e-mailadres en wachtwoord van 
					<a href="https://vine.co" target="_blank">
						vine.co
					</a>
				</small>
			</h2>
			<form method="POST">
				@if (isset($message))
					<span class="alert label toast-label">{{ $message }}</span>
				@endif
				<input name="username" type="text" placeholder="e-mail"
				       value="{{ isset($username) ? $username : '' }}"/>
				<input name="password" type="password" placeholder="wachtwoord"/>
				<button class="button expand">aanmelden</button>
				
				<a href="{{ URL::to('/terms') }}">Meer uitleg</a>&nbsp;&nbsp;&nbsp;
				<a href="{{ URL::to('/') }}">Annuleren</a>
			</form>
		</div>
	</div>

@include('_parts.footer')
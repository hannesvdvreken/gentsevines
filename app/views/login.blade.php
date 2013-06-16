@include('_parts.header')

	<div class="row first">
		<div class="large-12 columns text-center">
			<h1>
				login 
				<small>
					gebruik je e-mailadres en wachtwoord van 
					<a href="https://vine.co" target="_blank">
						vine.co
					</a>
				</small>
			</h1>
		</div>
	</div>

	<div class="row">
		<div class="large-8 large-centered columns">
			<form method="POST">
				@if (isset($message))
					<span class="alert label toast-label">{{ $message }}</span>
				@endif
				<input name="username" type="text" placeholder="e-mail"
				       value="{{ isset($username) ? $username : '' }}"/>
				<input name="password" type="password" placeholder="wachtwoord"/>
				<button class="button expand">aanmelden</button>
				<a href="{{ URL::to('/terms') }}">Meer uitleg</a>
			</form>
		</div>
	</div>

@include('_parts.footer')
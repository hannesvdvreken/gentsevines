<div class="fixed">
	<nav>
		<section class="centered">
			<a href="{{ URL::to('/') . "#" }}">
				<h1>
					Gentse 
					<img src="{{ URL::to('/assets/img/vine_logo.svg') }}" class="icon-vine" />
					<i>&apos;s</i>
				</h1>
			</a>
		</section>

		<section class="left">
			<ul>
				@if (isset($user))
				<a href="{{ URL::to('/logout/vine') }}">
					<li class="active"><img class="avatar" src="{{ $user->avatar }}" />{{ $user->username }}</li>
				</a>
				@else
				<a href="{{ URL::to('/login/vine') }}">
					<li class="active">Login</li>
				</a>
				@endif
				<li class="divider"></li>
			</ul>
		</section>

	</nav>
</div>
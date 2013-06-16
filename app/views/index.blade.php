@include('_parts.header')
@include('_parts.templates')
@include('_parts.nav')

	<script>
		var vines = {{ json_encode($vines) }};
	</script>

	<div class="row first">
		<div class="large-12 columns" id="vines-container">
		
		</div>
	</div>

@include('_parts.footer')
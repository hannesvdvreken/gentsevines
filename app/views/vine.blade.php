@include('_parts.header')
@include('_parts.templates')
@include('_parts.nav')

	<script>
		var vines = {{ json_encode(array($vine_id)) }};
		var static_page = true;
	</script>

	<div class="row first">
		<div class="large-12 columns" id="vines-container">
		
		</div>
	</div>

@include('_parts.footer')
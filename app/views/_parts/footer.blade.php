	<script src="{{ URL::to('/assets/js/vendor/zepto.js')}}"                     ></script>
	<script src="{{ URL::to('/assets/js/foundation.min.js')}}"                   ></script>
    <script src="{{ URL::to('/assets/js/app.js?v=2013061601')}}"                 ></script>
    @if (App::environment() == 'production')
    <script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-9732394-11', 'gentsevines.be');
	ga('send', 'pageview');
	</script>
    @endif
</body>
</html>
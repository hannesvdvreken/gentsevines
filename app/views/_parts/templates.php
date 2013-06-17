<script id="vine" type="text/html">
	<div class="vine-element row" id="vine-{{ id }}" 
	     data-id="{{ id }}"
	     data-video="{{ video }}">
		<div class="large-6 columns social">
			
			<div class="comments">
				<ul>
					<li class="owner">
						<img src="{{ user.avatar }}" />
						{{^user.twitter}}
							<span class="name">{{ user.username }}</span>
						{{/user.twitter}}
						{{#user.twitter}}
							<a class="name" target="_blank"
							   href="http://twitter.com/account/redirect_by_id?id={{ user.twitter }}">
								{{ user.username }}
							</a>
						{{/user.twitter}}
						{{ description }}
					</li>
				</ul>
			</div>
			<div class="likes">
				{{^likes.user_like }}
				<span class="btn"><i class="icon-heart"></i></span>
				{{/likes.user_like }}
				{{#likes.user_like }}
				<i class="icon-heart liked"></i>
				{{/likes.user_like }}
				<span class="like-count">{{ likes.count }}</span> likes.
			</div>
			<div class="share">
				<a href="https://twitter.com/intent/tweet?hashtags=gf13&original_referer=http%3A%2F%2Fgentsevines.be%2F&related=hannesvdvreken&text=%3C3%20Gent&url=http%3A%2F%2Fgentsevines.be%2F{{id}}"
				   target="_blank"
				>
					<span class="btn"><i class="icon-twitter"></i></span>
				</a>
				<a href="https://www.facebook.com/dialog/feed?
	app_id=183832018447263&
	link={{ base_url }}/{{ id }}&
	picture={{ thumbnail }}&
	name=Gentse+Vines&
	caption={{ user.username_esc }}&
	description={{ description_esc }}&
	redirect_uri={{ base_url }}/{{ id }}"
    			   target="_blank"
    			>
					<span class="btn"><i class="icon-facebook"></i></span>
				</a>
				{{^static_page}}
				<a href="{{ base_url }}/{{ id }}">
					<span class="btn"><i class="icon-ellipsis-horizontal"></i></span>
				</a>
				{{/static_page}}
			</div>
		</div>
		<div class="large-6 columns">
			<video src="{{ video }}" class="paused" loop>
				<img src="{{ thumbnail }}" />
			</video>
		</div>
	</div>
</script>

<script id="vine_video" type="text/html">
	
</script>
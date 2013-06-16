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
				<i class="icon-heart"></i>
				{{/likes.user_like }}
				{{#likes.user_like }}
				<i class="icon-heart liked"></i>
				{{/likes.user_like }}
				<span class="like-count">{{ likes.count }}</span> likes.
			</div>
		</div>
		<div class="large-6 columns">
			<img src="{{ thumbnail }}" onclick="javascript: start_vine(this);"/>
		</div>
	</div>
</script>

<script id="vine_video" type="text/html">
	<video src="{{ video }}" autoplay loop/>
</script>
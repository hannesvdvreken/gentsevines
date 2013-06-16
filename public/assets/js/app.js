/*
 |-------------------------------------------------------------------
 | Global
 |-------------------------------------------------------------------
 */

loading = false;

/*
 |-------------------------------------------------------------------
 | Events
 |-------------------------------------------------------------------
 */

$(document).ready(function(evt){

	// start timeout to fade error toast out
	init_fade_toast();

	// fully load vines
	init_display_vines();

});

$(window).scroll(function(evt) {

	// all vine elements that become visible: load!
	$('.trigger').each(function() {

		el = $(this);
		a = el.offset().top + 50;
		b = $(window).scrollTop() + $(window).height();
		if (a < b) {
			load_vines(el);
		}
	});
});

/*
 |-------------------------------------------------------------------
 | Loading functions
 |-------------------------------------------------------------------
 */

function init_fade_toast() {
	setTimeout(function() {
		$('.toast-label').animate({opacity: 0}, 'slow', 'ease-in');
	}, 4000);
}

function init_display_vines () {

	if (typeof(vines) == 'undefined') return false;

	if (vines.length == 0)
	{
		// set trigger for loading new vines
		set_new_trigger();

		// exit function
		return null;
	}

	// loop vines
	id = vines.shift();

	$.get(base_url + '/api/vine/' + id, function(data) {

		// show vines
		show_vine(data);

		// run again
		init_display_vines();
	});
}

function show_vine (vine_data) {

	// render
	html = ich.vine(vine_data);

	// html
	$('#vines-container').append(html);

	// apply event listeners
	$('.icon-heart').unbind('click'); // don't bind several times
	$('.icon-heart').on('click', like);

	// fade in
	$('.vine-element').animate({'opacity': 1}, 600);
}

function load_vines (el) {

	if (loading) return false;

	// global state
	loading = true;

	// get id's, use last id as ref
	elements = $('.vine-element');
	last = elements[elements.length - 1];
	last_vine_id = $(last).attr('data-id');

	// pull new
	url = base_url + '/api/load/' + last_vine_id + '/' + tag;

	$.get(url, function(data) {

		// loop result
		for (i in data) {
			vine_data = data[i];

			if ($('#vine-' + vine_data.id).length > 0) {
				// don't show this vine
				continue;
			}

			// show vine only if not existant
			show_vine(vine_data);
		}

		// set trigger for loading new vines
		set_new_trigger();

		// set loading to false
		loading = false;
	})
}

function start_vine (el) 
{
	// get surrounding div
	div = $(el).closest('.vine-element');

	// get video url
	video = div.data('video');

	// substitute thumbnail img for video
	p = $(el).parent();
	$(el).remove();
	p.append(ich.vine_video({"video": video}));

	$('video').unbind('click'); // don't bind several times
	$('video').on('click', function(evt) {

		video = evt.target;

		if ($(video).hasClass('paused'))
		{
			video.play();
			$(video).removeClass('paused');
		} else {
			video.pause();
			$(video).addClass('paused');
		}
	});
}

/*
 |-------------------------------------------------------------------
 | Helper
 |-------------------------------------------------------------------
 */

function set_new_trigger() {

	// variables
	classname = 'trigger';
	offset = 5;

	// delete all trigger elements
	$('.trigger').each(function(){
		$(this).removeClass(classname);
	});

	// set x last with extra class
	elements = $('.vine-element');

	// define index
	i = (elements.length < offset) ? 0 : elements.length - offset;
	
	// set class name
	$(elements[i]).addClass(classname);
}

/*
 |-------------------------------------------------------------------
 | Button handlers
 |-------------------------------------------------------------------
 */

function like(evt) {

	if ($(evt.target).hasClass('liked')) return dislike(evt);

	// get vine id out of dom
	vine_id = '' + $(evt.target).closest('.vine-element').attr('data-id');

	// build url
	url = base_url + '/api/like/' + vine_id;

	$.post(url, function(data) {

		if (data.success) {

			$(evt.target).addClass('liked');

			// update likes count
			current = parseInt($(evt.target).next().html(), 10);
			$(evt.target).next().html(current + 1);
		}
	});
}

function dislike(evt) {

	// get vine id out of dom
	vine_id = '' + $(evt.target).closest('.vine-element').attr('data-id');

	// build url
	url = base_url + '/api/dislike/' + vine_id;

	$.post(url, function(data) {

		if (data.success) {

			$(evt.target).removeClass('liked');
		}
	});
}
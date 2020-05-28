jQuery( document ).ready(function() {

	//Check if the ziggeo_app was defined
	if(typeof ziggeo_app === 'undefined') {
		return false;
	}

	//Handling video recorders
	ziggeo_app.embed_events.on("verified", function (embedding_object) {
		//lets get the embedding element
		var embedding = embedding_object.activeElement();

		if(!ziggeoninjaformsIsOfForm(embedding)) {
			//Not to be handled by us
			return false;
		}

		if(ZiggeoWP && ZiggeoWP.ninjaforms) {
			var _value = ZiggeoWP.ninjaforms.capture_format.replace('{token}', embedding_object.get("video"));
		}
		else {
			var _value = "[ziggeoplayer]" + embedding_object.get("video") + "[/ziggeoplayer]"
		}

		jQuery( '#' + embedding.getAttribute('data-id').trim() ).val( _value ).trigger( 'change' );
	});

	//Handling video players
	ziggeo_app.embed_events.on("ended", function (embedding_object) {
		//lets get the embedding element
		var embedding = embedding_object.activeElement();

		if(embedding.nodeName === "ZIGGEORECORDER") {
			return false;
		}

		if(!ziggeoninjaformsIsOfForm(embedding)) {
			//Not to be handled by us
			return false;
		}

		jQuery( '#' + embedding.getAttribute('data-id').trim() ).val( 'Video was seen' ).trigger( 'change' );
	});
});

// Just a simple function to check for signs of this embedding actually being part of Gravity Forms form
function ziggeoninjaformsIsOfForm(embedding) {

	if(embedding.getAttribute("data-is-nf")) {
		return true;
	}

	//Templates are processed differently, so we need to do additional check
	if(embedding.parentElement.getAttribute('data-is-nf')) {
		embedding.setAttribute('data-id', embedding.parentElement.getAttribute('data-id'));
		return true;
	}

	return false;
}

function ziggeoninjaformsGetTemplate(template_id, field_id) {
	ziggeoAjax({ operation: 'ziggeoninjaforms_get_template_code', template: template_id },
		function(response) {
			if(document.getElementById('ziggeoninjaforms-' + field_id)) {

				response = response.substr(1, response.length-2).replace(/\\/g, '');

				document.getElementById('ziggeoninjaforms-' + field_id).innerHTML = response;
			}
	});
}

//Special way to create the videowalls for Ninja Forms
function ziggeoninjaformsCreateVideoWall(videowall_id) {
	//videowall_id = 'videowall-nf-field-' + data.id
	//var id = videowall_id.replace('videowall-nf-field-', '');
	//var embed_placeholder = document.getElementById('ziggeoninjaforms-' + id);
	var embed_placeholder = document.getElementById(videowall_id);

	if(embed_placeholder === null) {
		setTimeout(function(){
			console.log(1);
			ziggeoninjaformsCreateVideoWall(videowall_id);
		}, 2000);
		return '';
	}

	/*
		data-videos-width="{{{data.videowidth}}}"
		data-videos-height="{{{data.videoheight}}}"
		data-videos-autoplay="{{{data.autoplay}}}"
		data-videos-autoplaytype=""
		data-indexing-perPage="{{{data.videos_per_page}}}"
		data-indexing-status="{{{data.show_videos}}}"
		data-indexing-design="{{{data.wall_design}}}"
		data-indexing-fresh="true"
		data-onNoVideos-showTemplate="{{{data.template_name}}}"
		data-onNoVideos-message="{{{data.message}}}"
		data-onNoVideos-templateName="{{{data.template_name}}}"
		data-onNoVideos-hideWall="{{{!data.show}}}"
		data-title="{{{data.title}}}"
		data-tags="{{{data.videos_to_show}}}"
	*/

	videowallszCreateWall(videowall_id, {
		videos: {
			width: embed_placeholder.getAttribute('data-videos-width'),
			height: embed_placeholder.getAttribute('data-videos-height'),
			autoplay: embed_placeholder.getAttribute('data-videos-autoplay'),
			autoplaytype: embed_placeholder.getAttribute('data-videos-autoplaytype')
		},
		indexing: {
			perPage: embed_placeholder.getAttribute('data-indexing-perPage'),
			status: embed_placeholder.getAttribute('data-indexing-status'),
			design: embed_placeholder.getAttribute('data-indexing-design'),
			fresh: true
		},
		onNoVideos: {
			showTemplate: embed_placeholder.getAttribute('data-onNoVideos-showTemplate'),
			message: embed_placeholder.getAttribute('data-onNoVideos-message'),
			templateName: embed_placeholder.getAttribute('data-onNoVideos-templateName'),
			hideWall: embed_placeholder.getAttribute('data-onNoVideos-hideWall')
		},
		title: embed_placeholder.getAttribute('data-title'),
		tags: embed_placeholder.getAttribute('data-tags')
	});

	if(embed_placeholder.getAttribute('data-show') === '1') {
		videowallszUIVideoWallShow(videowall_id);
	}
	else {
		ziggeo_app.embed_events.on("verified", function (embedding) {
			videowallszUIVideoWallShow(videowall_id);
		});
	}


}

function ziggeoninjaformsShowVideoWall(videowall_id) {
	//videowallszUIVideoWallShow(videowall_id);
}



/*
// On Document Ready...
jQuery( document ).ready( function( $ ) {

	ziggeoninjaformsInitFrontEndRenderVide();

});

//We do not really need this at this time
function ziggeoninjaformsInitFrontEndRenderVide() {
	// Create a new object for custom validation of a custom field.
	var ziggeoninjaformsViewRender = Marionette.Object.extend( {

		initialize: function() {
		
			// Listen to the render:view event for a field type. Example: Textbox field.
			this.listenTo( nfRadio.channel( 'video-player' ), 'render:view', this.renderView );
		},

		renderView: function( view ) {
		
			// Check if this is the right field. Example check for field key.
			//if ( 'example_key' != view.model.get( 'key' ) ) return false;
			// get element reference
			//var el = jQuery( view.el ).find( '.nf-element' );
			
			// Do stuff.
		}

	});

	// Instantiate our custom field's controller, defined above.
	new ziggeoninjaformsViewRender();
}
*/
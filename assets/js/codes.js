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

		//Get tags
		var tags = embedding.getAttribute('data-custom-tags');

		if(tags) {

			var _tags = [];
			tags = tags.split(',');

			for(i = 0, c = tags.length; i < c; i++) {
				try {
					var value = document.getElementById(tags[i]).value;

					if(value.trim() !== '') {
						_tags.push(value);
					}
				}
				catch(err) {
					console.log(err);
				}
			}

			if(_tags.length > 0) {

				if(embedding_object.get('tags') !== '' && embedding_object.get('tags') !== null) {
					_tags.concat(embedding_object.get('tags'));
				}

				//Create tags for the video
				ZiggeoApi.Videos.update(embedding_object.get("video"), {
					tags: _tags
				});
			}

		}
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
			ziggeoninjaformsCreateVideoWall(videowall_id);
		}, 2000);
		return '';
	}

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

//
// INDEX
//********
// 1. Helper functions
//		* jQuery.ready()
//		* ziggeoninjaformsIsOfForm()
//		* ziggeoninjaformsGetTemplate()
// 2. Videowalls
//		* ziggeoninjaformsCreateVideoWall()
//		* ziggeoninjaformsShowVideoWall()
// 3. Ziggeo Hooks
//		* ziggeofluentformsSaveToken()
//		* ziggeofluentformsAddCustomTags()
//		* ziggeofluentformsAddCustomData()


/////////////////////////////////////////////////
// 1. HELPER FUNCTIONS                         //
/////////////////////////////////////////////////


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

			var element = document.getElementById( embedding.getAttribute('data-id').trim() );
			var value_prepared = '';

			if(ZiggeoWP && ZiggeoWP.ninjaforms) {
				var value_prepared = ZiggeoWP.ninjaforms.capture_format.replace('{token}', embedding_object.get("video"));
			}
			else {
				var value_prepared = "[ziggeoplayer]" + embedding_object.get("video") + "[/ziggeoplayer]"
			}

			ZiggeoWP.hooks.fire('ziggeoninjaforms_verified', {
				'embedding_element': embedding,
				'embedding_object': embedding_object,
				'value_prepared': value_prepared,
				'save_to_element': element
			});

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

		//Set the hooks
		ziggeoninjaformsSaveToken();
		ziggeoninjaformsAddCustomTags();
		ziggeoninjaformsAddCustomData();
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

	//Helper to get the template used on the form
	function ziggeoninjaformsGetTemplate(template_id, field_id) {
		ziggeoAjax({ operation: 'ziggeoninjaforms_get_template_code', template: template_id },
			function(response) {
				if(document.getElementById('ziggeoninjaforms-' + field_id)) {

					response = response.substr(1, response.length-2).replace(/\\/g, '');

					document.getElementById('ziggeoninjaforms-' + field_id).innerHTML = response;
				}
		});
	}




/////////////////////////////////////////////////
// 2. VIDEOWALLS                               //
/////////////////////////////////////////////////

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




/////////////////////////////////////////////////
// 3. ZIGGEO HOOKS                             //
/////////////////////////////////////////////////

	//Helper to set the hook to capture and save the video token.
	function ziggeoninjaformsSaveToken() {
		ZiggeoWP.hooks.set('ziggeoninjaforms_verified', 'ziggeoninjaformsSaveToken',
			function(data) {
				//Save the video token
				data.save_to_element.value = data.value_prepared;
				jQuery(data.save_to_element).trigger('change'); //needed for ninja forms
			});
		//jQuery( '#' + embedding.getAttribute('data-id').trim() ).val( value_prepared ).trigger( 'change' );
	}

	//Handling save of custom (dynamic) tags
	function ziggeoninjaformsAddCustomTags() {
		ZiggeoWP.hooks.set('ziggeoninjaforms_verified', 'ziggeoninjaformsAddCustomTags',
			function(data) {
				//Get tags
				var tags = data.embedding_element.getAttribute('data-custom-tags');

				if(tags) {
					var _tags = [];
					tags = tags.split(',');

					for(i = 0, c = tags.length; i < c; i++) {
						try {
							var value = document.getElementById(tags[i]);

							if(value) {
								value = value.value.trim();
							}

							if(value.trim() !== '') {
								_tags.push(value);
							}
						}
						catch(err) {
							console.log(err);
						}
					}

					if(_tags.length > 0) {

						if(data.embedding_object.get('tags') !== '' && data.embedding_object.get('tags') !== null) {
							_tags.concat(data.embedding_object.get('tags'));
						}

						//Create tags for the video
						ziggeo_app.videos.update(data.embedding_object.get("video"), { tags: _tags });
					}
				}
			});
	}

	//Handling save of dynamic custom data
	function ziggeoninjaformsAddCustomData() {
		ZiggeoWP.hooks.set('ziggeoninjaforms_verified', 'ziggeoninjaformsAddCustomData',
			function(data) {
				//Get custom data
				var c_data = data.embedding_element.getAttribute('data-custom-data');
				//Example: first_name:nf-field-24,last_name:nf-field-25

				if(c_data) {
					var prepared_data = {};
					var _found = false;

					c_data = c_data.split(',');
					//Example: Array [ "first_name:nf-field-24", "first_name:nf-field-25" ]

					for(i = 0, c = c_data.length; i < c; i++) {
						try {

							var _temp = c_data[i].split(':');
							//Example: "Array [ "first_name", "nf-field-24" ]"

							var value = document.getElementById(_temp[1]);

							if(value) {
								value = value.value.trim();
							}
							else {
								value = '';
							}

							prepared_data[_temp[0]] = value;
							_found = true;
						}
						catch(err) {
							console.log(err);
						}
					}

					if(_found === true) {

						//We do not want to touch custom data that was there previosuly, so we either use one or the other.

						//Create tags for the video
						ziggeo_app.videos.update(data.embedding_object.get("video"), { data: prepared_data });
					}
				}
			});
	}

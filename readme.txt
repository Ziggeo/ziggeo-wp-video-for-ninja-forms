=== Ziggeo Video for Ninja Forms ===
Contributors: oliverfriedmann, baned, carloscsz409, natashacalleia
Tags: ziggeo, video, video field, form builder, video form, Ninja Forms
Requires at least: 3.0.1
Tested up to: 5.6
Stable tag: 1.4
Requires PHP: 5.2.4
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin brings video player and recorder (including screen recording) to your Ninja Forms. It helps you make it easy to add fields that utilize award winning Ziggeo to your forms.

Please note that you need to install and setup [Ziggeo plugin](https://wordpress.org/plugins/ziggeo/) first. This plugin is offered as an extension of the same.

== Who is this for? ==

Do you need to enrich your forms with multimedia?
Want to capture screen recording to help your support team when issues are submitted?
Looking to make your HR team work better and easier by offering camera recordgins and previews?
If any of the above is true, this plugin is what you want to add to your Wordpress website.

= Benefits =

Allows you to quickly add video playback and recording to your forms.
Ninja Forms native implementation of different Ziggeo solutions.
Add player, recorder, screen recorder and more to your forms.
Great support to offer you assistance with setup.

== Screenshots ==


== Installation ==
 
1. Upload plugin zip file to your plugins directory. Usually that would be to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. That is it or
1. Use the Plugins Add new section to find the plugin and install
 
== Frequently Asked Questions ==

= How does it work? =

This plugin will provide you with the Ziggeo Fields section in your form editor. Once you open it, it will reveal all of the different types of fields that we support.

By a simple drag and drop you can quickly add multimedia to your forms.

= Where does integration happen? =

Integration happens within your website. All the data you gather will still be available to you in same panels and integrations as before.

As always we will host multimedia that is captured within your Ziggeo account and link to the same will be used as a submitted value on your form.

= How to use Dynamic Custom Data =

Ziggeo internally supports the ability of adding custom data to your videos. This can be anything as long as it is provided as valid JSON field. Now with form builders you might want to add custom data based on the data in the fields as well. To do this, we bring you dynamic custom data field.

* Please note that this field should not be used in combination with the custom data. You should use either `Custom Data` or `Dynamic Custom Data`.

The way you would set it up is by using key:field_id. For example if you want your JSON to be formed as:

[javascript]
{
	"first_name": "Mike",
	"last_name": "Wazowski"
}
[/javascript]

and let's say that your first name has `<input id="nf-field-tmp-2" ...>` and last name has `<input id="nf-field-tmp-3" ...>`. It means that we need `nf-field-tmp-2` and `nf-field-tmp-3` to get those values. So our field can be set as:

`first_name:nf-field-tmp-2,last_name:nf-field-tmp-3`

As you save your recorder field it will remember this and try to find the values. If the fields with ID are not found, the value will be saved as "" (empty string)

= How can I get some support =

We provide active support to all that have any questions or need any assistance with our plugin or our service.
To submit your questions simply go to our [Help Center](https://support.ziggeo.com/hc/en-us). Alternatively just send us an email to [support@ziggeo.com](mailto:support@ziggeo.com).

= I have an idea or suggestion =

Please go to our [WordPress forum](https://support.ziggeo.com/hc/en-us/community/topics/200753347-WordPress-plugin) and add your suggestion within it. This allows everyone to see and vote on it and us to determine what should be next.

== Upgrade Notice ==

= 1.4 =
* Added: Now you can set the custom data from dynamic values. The only important part is that once verified event fires (after recording) it will try to capture the fields you set. It will not capture any changes made after.
* Added: Added hooks for the Ninja forms verified event, allowing you to add your own code handler to react once video is verified within the Ninja Forms form.
* Modified: Custom (dynamic) tags and capturing token is happening through the new verified event, allowing you to see how to set up and use the same.

== Changelog ==

= 1.3 =
* Improvement: API calls now use V2 only
* Improvement: Submenu creation now has a check to make sure that the core plugin is installed before calling it's function, which will help with any hidden errors during install if core plugin is not present.
* Improvement: Plugin is now going to report if the core plugin is not available instead of silently skipping the load of files.

= 1.2 =
* Added custom tags (tags based on other fields on the form) which are applied to the video once the video is verified.

= 1.1 =
* Cleanup and integrations updates

= 1.0 =
Initial commit

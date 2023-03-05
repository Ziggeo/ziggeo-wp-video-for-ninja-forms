This file contains the change log info for the `Ziggeo - Ninja Forms` Bridge plugin


=======

= 1.7 =
* Added: Support for the WP Core plugin lazyload feature
* Improvement: Submissions can be viewed in the Submissions panel even with Lazy Load feature turned on

= 1.6.2 =
* Fix: In some cases there was an error show in admin panel and this fix prevents it from happening.

= 1.6 =
* Fix: Setting what values to be saved was not working properly. This has been addressed with this new update. Your submissions could be saved in a different manner than default if your settings were set to something else. If this is the case, you can always change them by going to Ziggeo Video > Ziggeo Video for Ninja Forms in your WordPress dashboard.

= 1.5 =
* Improvement: Seems that in some cases Ninja Forms fields get some styles added that can make it harder to click on the upload file button. This update adds the CSS that address the same.

= 1.4 =
* Added: Now you can set the custom data from dynamic values. The only important part is that once verified event fires (after recording) it will try to capture the fields you set. It will not capture any changes made after.
* Added: Added hooks for the Ninja forms verified event, allowing you to add your own code handler to react once video is verified within the Ninja Forms form.
* Modified: Custom (dynamic) tags and capturing token is happening through the new verified event, allowing you to see how to set up and use the same.

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
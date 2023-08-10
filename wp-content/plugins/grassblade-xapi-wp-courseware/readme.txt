=== Experience API for WP Courseware by Grassblade ===
Contributors: liveaspankaj
Donate link: 
Tags: GrassBlade, xAPI, Experience API, Tin Can, WP Courseware, Articulate, Storyline, Captivate, iSpring, SCORM, SCORM 1.2, SCORM 2004
Requires at least: 4.0
Tested up to: 6.0.2
Stable tag: trunk
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

This plugin enables the Experience API (xAPI / Tin Can), cmi5, SCORM 1.2 and SCORM 2004 support on the WP Courseware LMS by integrating with GrassBlade xAPI Companion plugin. 


== Description ==

This plugin enables the Experience API (xAPI / Tin Can), cmi5, SCORM 1.2, SCORM 2004 and SCORM Dispatch packages support on the [WP Courseware LMS](https://www.nextsoftwaresolutions.com/r/wpcourseware/wordpress_plugin_page) by integrating with [GrassBlade xAPI Companion plugin](https://www.nextsoftwaresolutions.com/grassblade-xapi-companion/). 

Which authoring tools are supported:

* H5P 
* Articulate Storyline
* Articulate Rise
* Articulate Studio
* Articulate 360
* Adobe Captivate
* Lectora Inspire
* Lectora Publisher
* Lectora Online
* iSpring Suite
* Adapt Authoring Tool
* iSpring Pro
* DominKnow Claro
* and more not listed here


Videos Supported with [advanced video tracking](https://www.nextsoftwaresolutions.com/kb/advanced-video-tracking/): 

* YouTube
* Vimeo
* MP4 (self hosted or URL)
* MP3 (self hosted or URL)


What do you need? 

1. [WP Courseware LMS](https://www.nextsoftwaresolutions.com/r/wpcourseware/wordpress_plugin_page) plugin
1. [GrassBlade xAPI Companion](https://www.nextsoftwaresolutions.com/grassblade-xapi-companion/) plugin
1. [GrassBlade Cloud LRS](https://www.nextsoftwaresolutions.com/grassblade-lrs-experience-api/) (or GrassBlade LRS)

The LRS, also known as the Learning Record Store, is optional if you are using content without any tracking. 


What features do you get with this integration?

* Upload and host your xAPI and SCORM content zip packages.
* You can host content from several authoring tools.  
* Restrict progress till xAPI Content is completed
* Completion based on xAPI Content
* Use xAPI Content-based Quiz and its score in the reports. 
* Award Certificates based on completion of xAPI Content
* Generate detailed reports

**Available Reports**

Admins users can generate following reports to get complete insight on user activities.

* Completions Report
* Gradebook Report
* Achievements Report
* Progress Snapshot Report
* User Report

**GrassBlade xAPI Companion works with:**

* [LearnDash LMS](https://www.nextsoftwaresolutions.com/r/learndash/wordpress_plugin_page)
* [WP Courseware LMS](https://www.nextsoftwaresolutions.com/r/wpcourseware/wordpress_plugin_page)
* [LifterLMS](https://www.nextsoftwaresolutions.com/r/lifterlms/wordpress_plugin_page)
* [LearnPress LMS](https://www.nextsoftwaresolutions.com/r/learnpress/wordpress_plugin_page)
* [TutorLMS](https://www.nextsoftwaresolutions.com/r/tutorlms/wordpress_plugin_page)
* [MasterStudy LMS](https://www.nextsoftwaresolutions.com/r/masterstudy/wordpress_plugin_page)


== Installation ==

This section describes how to install the plugin and get it working.


1. Please make sure you have installed the other required plugins first as listed on the Details tab. 
1. Upload the plugin files to the `/wp-content/plugins/grassblade-xapi-wp-courseware` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Please follow the documentation of GrassBlade xAPI Companion for reset of the setup, 



== Frequently Asked Questions ==

= What is GrassBlade xAPI Companion plugin?  =

[GrassBlade xAPI Companion](https://www.nextsoftwaresolutions.com/grassblade-xapi-companion/) is a paid WordPress plugin that enables support for Experience API (xAPI)  based content on WordPress. 

It also provides best in industry Advanced Video Tracking feature, that works with YouTube, Vimeo and self-hosted MP4 videos. Tracking of MP3 audios is also supported. 

It can be used independently without any LMS. However, to add advanced features, it also has integrations with several LMSes. 

= What is WP Courseware LMS? =

[WP Courseware LMS](https://www.nextsoftwaresolutions.com/r/wpcourseware/wordpress_plugin_page) is a paid WordPress plugin which allows you to use Learning Management System features right on WordPress. It is very simple to use yet quite powerful and feature-rich.

= What is GrassBlade Cloud LRS? =

[GrassBlade Cloud LRS](https://www.nextsoftwaresolutions.com/grassblade-lrs-experience-api/) is a cloud-based Learning Record Store (LRS). An LRS is a required component in any xAPI-based ecosystem. It works as a data store of all eLearning data, as well as a reporting and analysis platform.  There is an installable version which can be installed on any PHP/MySQL based server. 


== Screenshots ==

1. Articulate content added using GrassBlade xAPI Companion
2. Quiz Report for Articulate Quiz on GrassBlade Cloud LRS 
3. Adding xAPI Content to WP Courseware Quiz page
4. Changing xAPI Content on WP Courseware Quiz page
5. YouTube Video added for Advanced Video Tracking
6. Video Tracking Heatmap on GrassBlade Cloud LRS
7. iSpring Content with Results at the bottom.
8. WP Courseware Quiz Summary with score from Articulate Quiz
9. GradeBook Report of WP Courseware with scores from Articulate Quiz
10. Completions Report
11. Gradebook Report
12. Progress Snapshot Report
13. Achievements Report
14. User Report


== Changelog ==

= 2.3 =
* Fixed: issues related to addons page specially on network website.

= 2.2 =
* Fixed: clicking Mark complete button after content completion is sending another attempted/completed statement
* Fixed: Reports: Error when course has no steps. 
* Fixed: Mark Complete button gets disabled even when completion tracking is disabled.
* Code cleanup and improvements

= 2.1 =
* Fixed: Completion button visible for a moment, and is clickable. 

= 2.0 =
* Feature: Added support for GrassBlade Reports.

= 1.8 =
* Fixed: Quiz edit page: Edit Content button taking user to all posts page if no content is selected.
* Fixed: minor notices.

= 1.7 = 
* Added Add-ons page

= 1.6 = 
* Fixed: Error on quiz edit page if xAPI Content is not selected.

= 1.5 = 
* Improved: Improved Trigger Log messages
* Fixed: Advanced Completion Behaviour: Mark Complete button is not disabled when using Enable on Completion.

= 1.4 =
* Added Advance Completion Behaviour of Mark Complete button.

= 1.3 =
* Fixed UI issue when GrassBlade plugin is not installed.

= 1.2 =
* Added textdomain for translation

= 1.1 = 
* Bug fix

= 1.0. = 
* New plugin added

== Description ==
Appetite is a clean, flexible and fully responsive WordPress theme with special features for restaurants and cafes. Also, this theme can be used for any other business sites.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Credits ==

* Based on Underscores http://underscores.me/, (C) 2012-2016 Automattic, Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)
* There are however some parts of this Theme which are not GPL but they are GPL-Compatible. See headers of JS files for further details.
* Theme uses FontAwesome library which is licensed under SIL OFL 1.1 : http://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&id=OFL
* Default font: Montserrat by Julieta Ulanovsky - SIL Open Font License, 1.1: http://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&id=OFL
* Default font: Lato by Łukasz Dziedzic - SIL Open Font License, 1.1: http://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&id=OFL
* This theme uses Bootstrap Framework - Licensed under the MIT : https://github.com/twbs/bootstrap/blob/master/LICENSE

== Changelog ==

= 1.1.8 May 8, 2018 =

* Update: move functionality of skip-link-focus-fix.js file to the theme JS file;
* Update: reduce number of http requests;
* Update: reorganize and optimize the theme JS file;

= 1.1.7 Apr 25, 2018 =

* Fix: date format when populating datetime attributes;
* Fix: move window.load outside of document.ready in the theme JS file;
* Fix: optimize the theme JS file and improve performance by avoiding to call the ready event multiple times;

= 1.1.6 Apr 6, 2018 =

* Add: support for Jetpack Content Options;
* Update: avoid repetitions by grouping elements with similar styling;
* Update: simplify a function that adds attributes (id and class) to the page header container;
* Update: verify ssl during the api request;
* Update: formatting of some files;
* Fix: PHP warning when the site does not have any posts;
* Fix: issue with menu titles in mobile views;
* Fix: display post categories section only for the Post type;
* Fix: do not display an empty "entry-meta" section if the current post type is not Post;

= 1.1.5 Mar 19, 2018 =

* Add: WooCommerce support;
* Update: optimize sticky header functionality;
* Fix: add missing language folder with several language files;
* Fix: page header paddings issue caused by the logo;

= 1.1.4 Mar 2, 2018 =

* Fix: replace wp_filter_post_kses with wp_kses_post, to remove an XSS vulnerability.

= 1.1.3 Feb 24, 2018 =

* Update: formatting of extras.php and jetpack.php files;
* Update: functionality of the theme's updater;
* Fix: color issue with the header links (IE);

= 1.1.2 Feb 13, 2018 =

* Add: transition speed option for the Featured Content slides;
* Add: social icons for Snapchat, Yelp and Tripadvisor;
* Add: sanitizing function for the number of posts output in the Front Page Blog Posts section;
* Add: allow a default title of the Front Page Blog Posts section to be translated into other languages;
* Add: active callback for Front Page options;
* Update: formatting of the theme JS core file;
* Update: formatting of the Customizer page;
* Update: section titles of the Front Page options in the Customizer;
* Update: move Featured Content autoplay option to the Theme Options section;
* Update: formatting of the file that displays recent blog posts on the Front Page template;
* Fix: Featured Page toggle issues in the Customizer;

= 1.1.1 Oct 25, 2017 =

* Update: add mobile class via PHP;
* Update: load slideshow script only for those pages where the script is used;
* Fix: script handle should use dashes rather than camelCase as per WP coding standards;
* Fix: hide site pagination if the Infinite Scroll is active;
* Fix: table styling issue when Infinite Scroll is active;

= 1.1 Oct 18, 2017 =

* Add: better rendering for the infinite scroll;
* Add: Medium, Telegram, Houzz and Xing social icons;
* Add: version number to the font icons file;
* Update: readme file formatting;
* Update: path for the Updater files;
* Update: font icons to a newer version;
* Update: path for the Updater files;
* Update: replace a custom theme pagination function with a native WordPress pagination function;
* Fix: display a social menu only if the menu is set;
* Fix: use strict comparisons;
* Fix: some minor formatting issues;
* Remove: unnecessary arguments from the social menu;

= 1.0.9 =

* Fix: issue associated with Featured Content transition speed;

= 1.0.8 =

* Add: option to change the speed of transitions between slides;

= 1.0.7 =

* Fix: styling issues on the Getting Started page;

= 1.0.6 =

* Update: functionality of theme updater;
* Update: several issues associated with the font sizes;
* Fix: the Getting Started page issues;

= 1.0.5 =

* Add: support for Recommended Plugins functionality;
* Fix: the custom credits issue;

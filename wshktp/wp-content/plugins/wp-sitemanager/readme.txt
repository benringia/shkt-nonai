=== WP SiteManager ===
Contributors: primestrategy, jim912
Tags: cms, mobile, sitemap, pager, page navi, breadcrumb
Requires at least: 3.5
Tested up to: 3.9
Stable tag: 1.0.15

WP SiteManager is an integrated package comprising of necessary functions for using WordPress as a CMS.

== Description ==
The functional value of WordPress as a CMS increases with each version, and the current 3.4 makes good usage of custom post types and custom taxonomies, meaning the creation of diverse content is possible. However, with these function additions, site structure has become complicated, and situations have arisen where the display of relevant navigation, such as site maps and breadcrumbs, does not appear as intended.

WP SiteManager makes it possible to make unified adjustments for this kind of inconsistent navigation using setup via control screens.
In addition, it also makes possible snippet optimization through management of meta information, and optimization of various environments through a theme switching function by device.

= Functions =
1. Site Map Display
2. Breadcrumb Display
3. Page Navigation (Pager) Display
4. Sub-Navigation Display
5. Device Recognition and Theme Switching Function
6. Settings for Meta Keywords & Description

= Usage =
* You can find settings of default taxonomy and taxonomy selection on Writing Settings.
* You can find setting of displaying taxonomies on Right Now in Your Profile.
* You can find "Term order" menu on Settings screen.
* You can find settings of displaying custom taxonomies on posts and pages list. 

== Installation ==

1. Upload the WP SiteManager folder to the plugins directory in your WordPress installation
2. Go to plugins list and activate "WP SiteManager". 

== Changelog ==
= 1.0.15 =
* change : add two filter hooks. "wp_sitemanager_meta_description_chars" and "wp_sitemanager_ogp_description_chars"

= 1.0.14 =
* fix : Strict standard error.
* change : OGP image size.

= 1.0.13 =
* fix : conflict with jetpack ogp.

= 1.0.12 =
* fix : Strict Standards error.

= 1.0.11 =
* fix : if web.config contain location tag, disallow rewrite this file.

= 1.0.10 =
* fix : theme_switcher.php Compilation failed Warning error.

= 1.0.9 =
* add : allow cache params setting.
* add : re-generate advanced-cache.php button.
* fix : comment cache bug.
* fix : refine delete single cache logic.
* screenshot images move to assets dir.

= 1.0.8 =
* fix : sitemap style typo.
* fix : conflict with "Trust Form"
* add : Theme Switcher supports Firefox mobile
* add : PC/Mobile mode switch "site-view"
* add : cache can other db.

= 1.0.7 =
* fix : debug message error.

= 1.0.5 =
* add : OGP and Twitter Cards.
* add : Cache clear setting.

= 1.0.4 =
* fix : some notice error.
* add : current class for sub navigation

= 1.0.3 =
* new : Simple caching system
* fix : "Creating default object from empty value" Warning error.

= 1.0.2 =
* new : add_conditional tag "is_device( 'device-slug' )" ex. theme_switcher::is_device( 'tablet' )

= 1.0.1 =
* Selectable sitemap style

= 1.0.0 =
* Released publically

== Screenshots ==
1. WP SiteManager Module management page.
2. SEO & SMO setting page.
3. Sitemap setting page.
4. Device theme setting page

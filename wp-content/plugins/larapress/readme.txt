=== Plugin Name ===
Contributors: graphems, loumray
Donate link: 
Tags: laravel, facades, sessions, authentication
Requires at least: 4.1.12
Tested up to: 4.6
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin enables you to use the Laravel Facades inside your Wordpress Theme. Especially usefull to check the Laravel authenticated user. 

== Description ==

This plugin enables you to use the Laravel Facades inside your Wordpress Theme. Especially usefull to check the Laravel authenticated user. 

This is very early version, please send suggestions. This is a BETA version so PLEASE DO NOT USE IN PRODUCTION ENVIRONMENT UNLESS YOU KNOW THE RISKS.

We have not fully tested the impact of loading Laravel with Wordpress. So we don't know yet if there are any negative impact or Conflict. Early test have shown it doesn't have much impact and no issues have been found. We appriciate all feedback to make this plugin more robust.

We provide no warranty.

This plugin require at least PHP 5.5.9 and Laravel 5. Don't bother asking question if you are not running PHP 5.5.9+ or Laravel 5.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Go to Settings > Laravel Bootstrap and then setup your Laravel 5 root directory.
4. Your current Wordpress web server need access to the Laravel folder, so make sure you are having the right folder setup. E.g: Install Wordpress inside the Laravel public folder as a subfolder like public/blog.


== Changelog ==

= 0.1 =
* Initial release
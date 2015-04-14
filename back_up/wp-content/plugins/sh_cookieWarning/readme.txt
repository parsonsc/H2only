=== ATag ===
Contributors: Scott Herbert
Donate link: http://scott-herbert.com
Tags: EU Law, Cookies, warning message
Requires at least: 2.1
Tested up to: 3.5.1
Stable tag: 1.0

Helps to make sure sites are complient with EU Privacy laws

== Description ==

This script injects a javascript warning into your wordpress page if a cookie isn't found, if the users accepts setting cookies then the site set a cookie for the user (so the message won't keep appearing) and lets the user access the page.
If the user doesn't accept cookies, the page redirects to google.

The plugin allows you to set the warning message to be displayed and the style of the warning.


== Installation ==

1. Install via your wp dash or upload the zip file to your '/wp-plugins/' directory and unzip into a folder called 'sh_cookieWarning'
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navagate to your theme's editor and within 'functions.php' add (at the end of the files fine),

function cookie_header() {
    do_action('cookie_header');
}
function cookie_body() {
    do_action('cookie_body');
}

1. Within the header.php file, locate the end of the 'head' section and the start of the 'body' sections
2. Within the 'head' section add the line <?php cookie_header(); ?>
2. Within the 'body' section add the line <?php cookie_body(); ?>


== Frequently Asked Questions ==

None

== Screenshots ==

None

== Changelog ==

= 1.0 =
* first version (released only via git-hub)

== Upgrade Notice ==

=== YandexPRO Blog ===

Contributors: YandexPRO Team
Requires at least: 6.0
Tested up to: 6.4
Requires PHP: 8.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

YandexPRO Blog is a modern WordPress theme designed specifically for blogs about internet marketing and Yandex Direct. It features a clean, professional design with excellent readability, mobile responsiveness, and SEO optimization.

== Features ==

* Responsive design that works on all devices
* Gutenberg editor support with custom block styles
* Multiple page templates (Landing, Blog, Contact)
* Customizer options for colors, fonts, and layout
* SEO-optimized with schema markup
* Accessibility ready (WCAG 2.1 compliant)
* Translation ready
* Custom widgets and navigation menus
* Social sharing functionality
* Newsletter subscription integration
* Reading time calculation
* Post views tracking
* Related posts system
* Table of contents for long articles

== Installation ==

1. Download the theme ZIP file
2. Go to Appearance → Themes in your WordPress admin
3. Click "Add New" then "Upload Theme"
4. Choose the ZIP file and click "Install Now"
5. Activate the theme

== Setup ==

1. Go to Appearance → Customize to configure:
   - Colors (primary and secondary)
   - Typography (font family)
   - Layout options
   - Logo and site identity

2. Set up menus:
   - Go to Appearance → Menus
   - Create a "Primary Menu" and assign it to "Primary Menu" location
   - Optionally create a footer menu

3. Configure homepage:
   - Go to Settings → Reading
   - Set "Your homepage displays" to "A static page"
   - Choose or create pages for homepage and blog

4. Import starter content:
   - The theme includes starter content that will be imported automatically
   - Or manually create pages using the included page templates

== Page Templates ==

* Landing Page - Full-width template for landing pages
* Blog Page - Template for displaying blog posts
* Contact Page - Contact form with business information

== Customization ==

The theme can be customized through the WordPress Customizer without code:

* Colors: Primary and secondary color schemes
* Typography: Choose from system fonts or Google Fonts
* Layout: Container width and blog layout options
* Header: Logo, site title, and navigation
* Footer: Widgets and footer menu

For developers: The theme follows WordPress coding standards and is child-theme ready.

== Child Theme ==

To create a child theme:

1. Create a new folder in /wp-content/themes/ named "yandexpro-blog-child"
2. Create style.css with the following header:

```css
/*
Theme Name: YandexPRO Blog Child
Template: yandexpro-blog
Version: 1.0.0
*/

@import url("../yandexpro-blog/style.css");
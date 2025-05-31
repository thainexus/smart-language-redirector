=== Smart Language Redirector ===
Contributors: thainexus  
Tags: language redirect, translatepress, wpml, multilingual, browser language  
Requires at least: 5.2  
Tested up to: 6.8  
Requires PHP: 7.2  
Stable tag: 1.0.1  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html  

Redirect visitors to their preferred language version based on browser settings. Works with any translation plugin.

== Description ==

Smart Language Redirector checks your visitor's browser language and automatically redirects them to the appropriate language version of your site — just once, using a cookie.

Perfect for multilingual WordPress websites using:

- TranslatePress (free or paid)
- WPML
- Polylang
- Or any custom folder-based translation system

No need to pay extra for TranslatePress’s premium redirect addon.

= Features =

- Detects browser language and redirects once
- Supports any language path (e.g., /en/, /fr/, /de/)
- Remembers user preference with a cookie
- Lightweight and fully compatible with caching plugins
- Admin panel with live test tool and fallback settings
- Works even without a translation plugin
- Developed by Thai Nexus for real-world business needs

= Example =

Your homepage is in Thai (`/`) and you have English at `/en/` and French at `/fr/`.  
A first-time visitor using a French browser is redirected to `/fr/`, and from then on, their choice is remembered.

== Installation ==

1. Upload the plugin ZIP via Plugins → Add New → Upload
2. Activate the plugin
3. Go to **Settings → Language Redirector**
4. Choose your root language and list your translated paths (e.g., `en,fr,pl`)
5. Save and test using the built-in preview

== Frequently Asked Questions ==

= Will this work with TranslatePress? =  
Yes, it works perfectly with TranslatePress. Just enter your language slugs manually if needed.

= Can I use this without TranslatePress or WPML? =  
Yes. You can enter your language slugs manually.

= Is the redirect forced every time? =  
No — it only happens on the first visit. After that, the user’s language preference is remembered using a cookie.

= What if my homepage is already in English? =  
Set `en` as your root language in the settings. Redirects will only happen when a different language is detected.

== Screenshots ==

1. Admin settings page
2. Browser language test tool
3. Example redirection behavior

== Changelog ==

= 1.0 =
* Initial public release with full redirect and TranslatePress detection support

== Upgrade Notice ==

= 1.0 =
First release — stable and safe for production use

== Credits ==

Built by [Thai Nexus](https://thainexus.co.th/wordpress-plugins/smart-language-redirector), helping international teams set up business and logistics operations in Thailand.

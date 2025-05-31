<?php
/**
 * Plugin Name: Smart Language Redirector
 * Description: Redirects first-time visitors based on browser language. Cookie prevents repeated redirects. Compatible with any translation plugin.
 * Version: 1.0
 * Author: Thai Nexus
 * Plugin URI: https://thainexus.co.th/wordpress-plugins/smart-language-redirector
 * Author URI: https://thainexus.co.th
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined('ABSPATH') || exit;

function slr_register_settings() {
    register_setting('slr_settings_group', 'slr_enabled', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('slr_settings_group', 'slr_root_lang', ['sanitize_callback' => 'sanitize_text_field']);
    register_setting('slr_settings_group', 'slr_cookie_lifetime', ['sanitize_callback' => 'absint']);
    register_setting('slr_settings_group', 'slr_supported_languages', ['sanitize_callback' => 'sanitize_text_field']);
}
add_action('admin_init', 'slr_register_settings');

function slr_plugin_action_links($links) {
    $settings_link = '<a href="options-general.php?page=smart-language-redirector">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'slr_plugin_action_links');

function slr_add_admin_menu() {
    add_options_page('Smart Language Redirector', 'Language Redirector', 'manage_options', 'smart-language-redirector', 'slr_settings_page');
}
add_action('admin_menu', 'slr_add_admin_menu');

function slr_settings_page() {
    $saved_langs = get_option('slr_supported_languages', 'en,th');
    ?>
    <div class="wrap">
        <h1>🌐 Smart Language Redirector</h1>
        <p><strong>Thai Nexus</strong> plugin for redirecting visitors to their preferred language version of your site based on browser settings.</p>

        <div style="background: #f1f1f1; padding: 15px; border-left: 4px solid #0073aa; margin-bottom: 20px;">
            <strong>📌 How to Use</strong><br>
            - Automatically redirect first-time visitors from <code>/</code> to their browser language.<br>
            - Supports any translation plugin, including TranslatePress.<br>
            - Set the root language — your homepage without a subdirectory.<br>
            - Cookie prevents future redirects. Supports <code>en, th, fr, de, pl</code>, etc.
        </div>

        <form method="post" action="options.php">
            <?php settings_fields('slr_settings_group'); ?>
            <?php do_settings_sections('slr_settings_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Enable Redirection</th>
                    <td><input type="checkbox" name="slr_enabled" value="1" <?php checked(get_option('slr_enabled', 1), 1); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Root Language (Default)</th>
                    <td><input type="text" name="slr_root_lang" value="<?php echo esc_attr(get_option('slr_root_lang', 'th')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Cookie Lifetime (minutes)</th>
                    <td><input type="number" name="slr_cookie_lifetime" value="<?php echo esc_attr(get_option('slr_cookie_lifetime', 60)); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Supported Languages</th>
                    <td>
                        <input type="text" name="slr_supported_languages" value="<?php echo esc_attr($saved_langs); ?>" />
                        <p class="description">Comma-separated list (e.g., <code>en,th,fr,pl,de</code>)</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>

        <hr>
        <h2>Test Tool</h2>
        <p>Your browser language is: <strong><span id="slr-browser-lang"></span></strong></p>
        <script>
            document.getElementById('slr-browser-lang').innerText = navigator.language || navigator.userLanguage;
        </script>

        <hr>
        <h2>💡 Thai Nexus Tip</h2>
        <p style="font-size: 16px; max-width: 600px;">
            Looking for a reliable business address in Thailand — or planning to live here long-term?<br><br>
            <strong>Thai Nexus</strong> offers:<br>
            - Study, retirement, marriage, or work visa support<br>
            - Virtual business or private addresses<br>
            - International mail forwarding and ecommerce shipping from Thailand<br><br>
            <a href="https://thainexus.co.th" target="_blank" class="button button-primary">Visit Thai Nexus</a>
        </p>
    </div>
    <?php
}

function slr_redirect_based_on_language() {
    if (is_admin()) return;

    $enabled = get_option('slr_enabled', 1);
    if (!$enabled) return;

    $request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';
    $root_lang = get_option('slr_root_lang', 'th');
    $cookie_lifetime = (int) get_option('slr_cookie_lifetime', 60);
    $supported = explode(',', str_replace(' ', '', get_option('slr_supported_languages', 'en,th')));

    if (!empty($_COOKIE['lang_redirected'])) return;
    if ($request_uri !== '/' && $request_uri !== '/index.php') return;

    $accept = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_ACCEPT_LANGUAGE'])) : '';
    $browser_lang = substr($accept, 0, 2);

    if (in_array($browser_lang, $supported) && $browser_lang !== $root_lang) {
        setcookie('lang_redirected', $browser_lang, time() + 60 * $cookie_lifetime, "/");
        wp_redirect(home_url("/$browser_lang/"));
        exit;
    }
}
add_action('init', 'slr_redirect_based_on_language', 10);

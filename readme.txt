=== Easy Debug Logger ===
Contributors: zeeshanyousaf343
Tags: debug, error log, live stream, developer console, debugger
Requires at least: 5.0
Tested up to: 7.0
Requires PHP: 8.0
Stable tag: 0.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A lightweight, secure, and live-streaming WordPress error log viewer with real-time updates, color-coded error parsing, and one-click configuration.

== Description ==

Easy Debug Logger allows developers to view and manage WordPress error logs directly from the administration dashboard. It features live streaming updates using an efficient byte-offset polling mechanism, keyword-based color coding for warnings/errors/notices, search filtering, log clear and download options, and a click option to configure WP_DEBUG mode.

Developer Profile: [Zeeshan Yousaf](https://profiles.wordpress.org/zeeshanyousaf343/)  
LinkedIn: [Zeeshan Yousaf](https://www.linkedin.com/in/devzeeshanyousaf)

---

### Key Features & Functionality

1. **Live Auto-Refresh Stream**
   * Uses an optimized byte-offset polling engine to retrieve new log entries every 4 seconds.
   * Only transfers new content, keeping AJAX operations extremely lightweight.
   * Auto-scroll keeps focus on new entries and automatically pauses when you manually scroll up to inspect past logs.
   * Live streaming can be manually paused/resumed via the primary button.

2. **Color-Coded Log Parsing**
   * Automatically parses and highlights critical segments for high scannability:
     * **Bright Red** (Border & tint background): Fatal Error, Uncaught Exception, Critical.
     * **Orange/Yellow**: Warning.
     * **Muted Blue/Gray**: Notice, Deprecated, Strict.
     * **Cyan/Light Blue**: Timestamps.

3. **One-Click Debug Mode Setup**
   * If `WP_DEBUG_LOG` is disabled, the plugin outputs a warning panel.
   * If `wp-config.php` is writable, the warning includes a button to automatically define and set `WP_DEBUG` and `WP_DEBUG_LOG` to `true`.
   * The page auto-reloads and starts streaming instantly.

4. **Log File Actions**
   * **Download Full Log**: Generates a secure, attachment-disposition raw file download using GMT file markers.
   * **Clear Log**: Empties/truncates the `debug.log` file using safe file stream pointer truncation (`ftruncate`), resetting the byte offset dynamically.

5. **Terminal View & UX Controls**
   * **Search Filter**: Real-time JavaScript filter that hides lines that don't match your keyword without reloading the logs.
   * **Font Size Adjuster**: Toggle the terminal code size between 11px and 16px to fit your workspace.
   * **Copy Console text**: Copies the filtered log lines directly to your clipboard with one click.
   * **Plugins Page Action Link**: Adds a direct "View Logs" link under the plugin name on the WordPress plugins page.

6. **Strict Security & CSRF Protection**
   * Locked to users with the `manage_options` capability.
   * Secure CSRF protection using nonces on all read, clear, download, and configure requests.
   * HTML sanitization (`esc_html()`) on all parsed text to prevent XSS.

== Installation ==

1. Upload the `easy-debug-logger` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Access the log viewer via Tools > Easy Debug Logger, or click "View Logs" on the Plugins page.

== FAQ ==

= Do I need to enable WP_DEBUG manually? =
If `WP_DEBUG_LOG` is disabled, the plugin notice will offer to enable it automatically for you if your `wp-config.php` file is writable. If not, it will display instructions.

= How does the live stream affect server performance? =
It has zero impact. Unlike regular viewers that read the entire log file on every request (which crashes servers if logs are large), Easy Debug Logger uses a byte offset. The browser sends its current read position, and PHP seeks directly to that position, only reading and sending the newly added characters.

= Can I use it on production? =
Yes, because it is restricted entirely to Administrator-level users with the `manage_options` capability and protected by security nonces. However, keeping `WP_DEBUG` enabled on production is generally discouraged.

== Screenshots ==

1. The dark-themed terminal console displaying live logs.
2. The tools panel including clear, download, font sizing, and filter controls.
3. The automatic `WP_DEBUG_LOG` activation notice.

== Changelog ==

= 0.0.1 =
* Initial release.

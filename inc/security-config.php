<?php
/**
 * Security Configuration for Victoria Style Theme
 * Prevents unauthorized database access and strengthens security
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    header('HTTP/1.0 403 Forbidden');
    exit('Direct access forbidden.');
}

// Disable file editing in WordPress admin
if (!defined('DISALLOW_FILE_EDIT')) {
    define('DISALLOW_FILE_EDIT', true);
}

// Disable file modifications
if (!defined('DISALLOW_FILE_MODS')) {
    define('DISALLOW_FILE_MODS', true);
}

// Hide WordPress version
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Remove version from scripts and styles
function victoria_style_remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'victoria_style_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'victoria_style_remove_version_scripts_styles', 9999);

// Disable user enumeration
add_action('init', function() {
    if (!is_admin() && isset($_REQUEST['author'])) {
        wp_die('User enumeration is disabled.', 'Security Alert', 403);
    }
});

// Block direct access to theme files
add_action('init', function() {
    $blocked_files = array(
        'functions.php',
        'header.php', 
        'footer.php',
        'index.php',
        'sidebar.php'
    );
    
    $current_file = basename($_SERVER['PHP_SELF']);
    if (in_array($current_file, $blocked_files) && !defined('ABSPATH')) {
        header('HTTP/1.0 403 Forbidden');
        exit('Direct access forbidden.');
    }
});

// Prevent PHP execution in uploads
add_action('admin_init', function() {
    $upload_dir = wp_upload_dir();
    $htaccess_file = $upload_dir['basedir'] . '/.htaccess';
    
    if (!file_exists($htaccess_file)) {
        $rules = "# Disable PHP execution\n";
        $rules .= "<Files *.php>\n";
        $rules .= "deny from all\n";
        $rules .= "</Files>\n";
        file_put_contents($htaccess_file, $rules);
    }
});

// Login security - limit login attempts
add_action('wp_login_failed', function($username) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient('failed_login_' . $ip);
    
    if ($attempts === false) {
        set_transient('failed_login_' . $ip, 1, 900); // 15 minutes
    } else {
        set_transient('failed_login_' . $ip, $attempts + 1, 900);
        
        if ($attempts + 1 >= 5) {
            // Log security alert
            $log_file = WP_CONTENT_DIR . '/security-alerts.log';
            $log_entry = sprintf(
                "[%s] Multiple failed login attempts from IP: %s for username: %s\n",
                date('Y-m-d H:i:s'),
                $ip,
                $username
            );
            file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
        }
    }
});

// Check login attempts before allowing login
add_filter('authenticate', function($user, $username, $password) {
    if (empty($username) || empty($password)) {
        return null;
    }
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $attempts = get_transient('failed_login_' . $ip);
    
    if ($attempts && $attempts >= 5) {
        return new WP_Error('too_many_attempts', 
            'Too many failed login attempts. Please try again later.');
    }
    
    return $user;
}, 30, 3);

// Sanitize file uploads
add_filter('wp_handle_upload_prefilter', function($file) {
    // Check for PHP code in uploaded files
    if (isset($file['tmp_name'])) {
        $file_content = file_get_contents($file['tmp_name']);
        
        // Check for PHP tags and dangerous functions
        $dangerous_patterns = array(
            '<?php', '<script', 'eval(', 'base64_decode',
            'system(', 'exec(', 'shell_exec(', 'passthru(',
            'mysqli', 'mysql_connect', 'DB_HOST', 'DB_USER'
        );
        
        foreach ($dangerous_patterns as $pattern) {
            if (stripos($file_content, $pattern) !== false) {
                $file['error'] = 'Security: File contains suspicious code.';
                
                // Log the attempt
                $log_file = WP_CONTENT_DIR . '/security-alerts.log';
                $log_entry = sprintf(
                    "[%s] Blocked malicious file upload: %s from IP: %s\n",
                    date('Y-m-d H:i:s'),
                    $file['name'],
                    $_SERVER['REMOTE_ADDR']
                );
                file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
                
                return $file;
            }
        }
    }
    
    return $file;
});

// Disable dangerous PHP functions for theme
if (!function_exists('victoria_style_disable_dangerous_functions')) {
    function victoria_style_disable_dangerous_functions() {
        // These would normally be disabled in php.ini
        $dangerous_functions = array(
            'exec', 'system', 'shell_exec', 'passthru',
            'eval', 'file_get_contents', 'file_put_contents',
            'curl_exec', 'curl_multi_exec', 'parse_ini_file',
            'show_source', 'proc_open', 'proc_get_status'
        );
        
        // Log if any of these functions are being called
        foreach ($dangerous_functions as $func) {
            if (function_exists($func)) {
                // In production, these should be disabled at server level
                // Here we just log their availability
                error_log("Warning: Dangerous function '$func' is available");
            }
        }
    }
}

// Add security headers (only if mod_headers is not available in .htaccess)
add_action('send_headers', function() {
    if (!headers_sent()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    }
});

// Validate WordPress database connection
add_action('init', function() {
    global $wpdb;
    
    // Ensure only WordPress can access the database
    if (!defined('DB_NAME') || !defined('DB_USER') || 
        !defined('DB_PASSWORD') || !defined('DB_HOST')) {
        wp_die('Invalid database configuration.', 'Security Alert', 500);
    }
    
    // Check if someone is trying to use custom database credentials
    if (isset($_GET['DB_HOST']) || isset($_POST['DB_HOST']) ||
        isset($_GET['DB_NAME']) || isset($_POST['DB_NAME']) ||
        isset($_GET['DB_USER']) || isset($_POST['DB_USER']) ||
        isset($_GET['DB_PASS']) || isset($_POST['DB_PASS'])) {
        
        // Log security breach attempt
        $log_file = WP_CONTENT_DIR . '/security-alerts.log';
        $log_entry = sprintf(
            "[%s] CRITICAL: Database credential injection attempt from IP: %s\n",
            date('Y-m-d H:i:s'),
            $_SERVER['REMOTE_ADDR']
        );
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
        
        // Block the request
        header('HTTP/1.0 403 Forbidden');
        wp_die('Security violation detected. This incident has been reported.', 'Security Alert', 403);
    }
});
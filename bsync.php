<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @category Wordpress_Plugin
 * @package  Bsync
 * @author   Wesley Useche <wesleyuseche@gmail.com>
 * @license  GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link     https://electronicmaji.github.io/usewes/
 * @since    1.0.0
 * 
 * @wordpress-plugin
 * Plugin Name:       Buzzsprout Sync
 * Plugin URI:        https://our-hometown.com/
 * Description:       Buzzsprout Sync pulls in Social Media Widgets for a Buzzsprout Feed.
 * Version:           1.0.0
 * Author:            Wesley Useche
 * Author URI:        https://electronicmaji.github.io/usewes/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bsync
 * Domain Path:       /languages
 */

// If this file is called directly, abort.

if (! defined('WPINC') ) {
    die;
}

if(class_exists('AdminMenu') ) {
    $AdminMenu = new AdminMenu();
}

if (file_exists(dirname(__FILE__) . '/includes/ScrapeBuzz.php') ) {
    include_once dirname(__FILE__) . '/includes/ScrapeBuzz.php';
}


if (file_exists(dirname(__FILE__) . '/includes/MediaWidget.php') ) {
    include_once dirname(__FILE__) . '/includes/MediaWidget.php';
}



/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('BSYNC_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bsync-activator.php
 */
function activate_bsync()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-bsync-activator.php';
    Bsync_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bsync-deactivator.php
 */
function deactivate_bsync()
{
    include_once plugin_dir_path(__FILE__) . 'includes/class-bsync-deactivator.php';
    Bsync_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_bsync');
register_deactivation_hook(__FILE__, 'deactivate_bsync');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-bsync.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_bsync()
{

    $plugin = new Bsync();
    $plugin->run();

}
run_bsync();






/**
 * This class initializes all menu items for the plugin.
 * 
*/

 class AdminMenu
{

    public function register()
    {

        add_action('admin_enqueue_scripts', array( $this, 'enqueue' ));

        add_action('admin_menu', array( $this, 'add_admin_menu' ));

        add_action('admin_menu', array( $this, 'buzzsprout_sync_settings' ));

     


    }

    public function add_admin_menu()
    {
        add_options_page( 
            'Buzzsprout Sync',
            'Buzzsprout Sync Settings',
            'manage_options',
            'buzzsprout-sync.php',
            array ( $this, 'admin_index' ),
        );
    }

    /**
     * Registers a new options setting, page, section, and form under Settings for the plugin.
     */
    public function buzzsprout_sync_settings()
    {
        register_setting(
            'podcast_info',
            'podcastid',
            array(
            'type'              => 'string',
            'description'      => 'podcast_id',
            'sanitize_callback' => 'sanitize_text_field',
                 )
        );
        add_settings_section(
            'buzz-form-container',
            'Podcast URL',
            'setting_form_1',
            'buzzsprout-sync.php',
        );
        add_settings_field(
            'buzz_form', 
            'Podcast ID',
            'podcast_id',
            'buzzsprout-sync.php',
            'buzz-form-container', 
            [
                'label_for' => 'podcastid'
            ] 
        );
            
    }

    
    function enqueue()
    {
        // enqueue all our scripts
        wp_enqueue_style('mypluginstyle', plugins_url('/assets/css/admin.css', __FILE__));
    }    


    function admin_index()
    {
        include_once plugin_dir_path(__FILE__) . 'templates/admin.php';
    }

    

}






if(class_exists('AdminMenu') ) {
    $AdminMenu = new AdminMenu();
}




$AdminMenu = new AdminMenu();
$AdminMenu->register();


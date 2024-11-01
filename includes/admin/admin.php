<?php

/*
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Plugin 'WFPC' class.
 */
if (!class_exists('WFPC_Admin')) {
    class WFPC_Admin
    {
        /**
         * 'wfpc-plugin' constructor.
         *
         * The main plugin actions registered for WordPress
         */
        public function __construct()
        {

            $this->hooks();
        }

        /**
         * Initialize
         */
        public function hooks()
        {
            add_filter('plugin_action_links_' . WFPC_BASENAME,  array($this, 'wfpc_plugin_links'));
            add_action('admin_menu', array($this, 'wfpc_add_menu'));
            add_action('admin_head', array($this, 'wfpc_plugin_active_tooltip'));
        }

        /**
         * add menu in admin panel
         */
        public function wfpc_add_menu()
        {
            add_menu_page(esc_html__('WFP Captcha Settings', 'wfpc-plugin'), esc_html__('WFP Captcha', 'wfpc-plugin'), 'administrator', 'wfpc_getting_started', array($this, 'wfpc_main_screen'));
			
        }

        /**
         * Display links
         */
        public function wfpc_plugin_links($links)
        {
            $start_page = 'wfpc_getting_started';

            $links['settings'] = '<a href="' . admin_url("admin.php?page=$start_page") . '" title="' . esc_html__('Gettting Started', 'wfpc-plugin') . '">' . esc_html__('Settings', 'wfpc-plugin') . '</a>';
            return $links;
        }

        /**
        *
        * Shows welcome message on plugin active.
        */
        public function wfpc_plugin_active_tooltip()
        {
            global $pagenow;
            $check_welcome = get_option('wfpc_check_welcome', true);
            if ($check_welcome == 'yes') {
                return;
            }
            if (!in_array($pagenow, array('plugins.php'))) {
                return;
            }
            ?>
            <div class="wfpc-activate-tooltip">
                <form method="post" action="<?php echo admin_url('admin.php') . "?page=wfpc_getting_started&from=active-wfpc"; ?>">
                    <div class="wfpc-tooltip-content">
                        <div class="wfpc-tooltip-header">
                            <h3><?php esc_html_e('WFP Captcha Settings', 'wfpc-plugin'); ?></h3>
                        </div>
                        <div class="wfpc-tooltip-innercontent">
                            <p><?php esc_html_e('Welcome to the WP Forms Puzzle Captcha', 'wfpc-plugin'); ?></p>
                        </div>
                        <div class="wfpc-tooltip-footer wfpc-text-right">
                            <button type="submit" name="wfpc-wlcm-submit" class="wfpc-welcm-btn button button-primary"><?php esc_html_e('Press here to start!', 'wfpc-plugin'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        <?php
        }
		
		/**
        *
        * Shows setting page of the plugin.
        */
        public function wfpc_main_screen() {
			if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];
			}
			else{
				$active_tab = "wfpc-intro";
			}
            global $wpdb;
            $current_active_theme = wp_get_theme();
            $active_theme_name = $current_active_theme->get('Name');
            if (isset($_GET['from']) && $_GET['from'] == 'active-wfpc') {
                update_option('wfpc_check_welcome', 'yes');
            }

            ?>
			<div class="wrap">
				<h1 class="wp-heading-inline"><?php echo esc_html__('WFP Captcha Settings', 'wfpc-plugin'); ?></h1>
				<h2 class="nav-tab-wrapper">
					<a href="?page=wfpc_getting_started&tab=wfpc-intro" class="nav-tab<?php echo $active_tab == 'wfpc-intro' ? ' nav-tab-active' : ''; ?>"><?php echo esc_html__('Introduction', 'wfpc-plugin'); ?></a>
					<a href="?page=wfpc_getting_started&tab=wfpc-login" class="nav-tab<?php echo $active_tab == 'wfpc-login' ? ' nav-tab-active' : ''; ?>"><?php echo esc_html__('WordPress Login Form', 'wfpc-plugin'); ?></a>
					<a href="?page=wfpc_getting_started&tab=wfpc-register" class="nav-tab<?php echo $active_tab == 'wfpc-register' ? ' nav-tab-active' : ''; ?>"><?php echo esc_html__('WordPress Register Form', 'wfpc-plugin'); ?></a>				<a href="?page=wfpc_getting_started&tab=wfpc-comment" class="nav-tab<?php echo $active_tab == 'wfpc-comment' ? ' nav-tab-active' : ''; ?>"><?php echo esc_html__('Comment Form', 'wfpc-plugin'); ?></a>
					<a href="?page=wfpc_getting_started&tab=wfpc-lost-password" class="nav-tab<?php echo $active_tab == 'wfpc-lost-password' ? ' nav-tab-active' : ''; ?>"><?php echo esc_html__('Lost Password Form', 'wfpc-plugin'); ?></a>
					<a href="?page=wfpc_getting_started&tab=wfpc-cf7" class="nav-tab<?php echo $active_tab == 'wfpc-cf7' ? ' nav-tab-active' : ''; ?>"><?php echo esc_html__('Contact Form 7', 'wfpc-plugin'); ?></a>
				</h2>
				<?php require_once "tabs/".$active_tab.".php"; ?>
			</div>
		<?php
        }
    }
}

/*
* Starts wp-admin action
*/
new WFPC_Admin();

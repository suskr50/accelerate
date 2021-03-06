<?php

class MC4WP_Lite_Admin
{

	/**
	 * @var bool True if the BWS Captcha plugin is activated.
	 */
	private $has_captcha_plugin = false;

	/**
	 * @var string The relative path to the main plugin file from the plugins dir
	 */
	private $plugin_file;

	/**
	 * @var MC4WP_MailChimp
	 */
	protected $mailchimp;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->plugin_file = plugin_basename( MC4WP_LITE_PLUGIN_FILE );
		$this->mailchimp = new MC4WP_MailChimp();
		$this->load_translations();
		$this->setup_hooks();
		$this->listen();

		// Instantiate Usage Tracking nag
		$options = mc4wp_get_options( 'general' );
		if( ! $options['allow_usage_tracking'] ) {
			$usage_tracking_nag = new MC4WP_Usage_Tracking_Nag( $this->get_required_capability() );
			$usage_tracking_nag->add_hooks();
		}
	}

	/**
	 * Upgrade routine
	 */
	private function load_upgrader() {

		// Only run if db option is at older version than code constant
		$db_version = get_option( 'mc4wp_lite_version', 0 );
		if( version_compare( MC4WP_LITE_VERSION, $db_version, '<=' ) ) {
			return false;
		}

		$upgrader = new MC4WP_DB_Upgrader( MC4WP_LITE_VERSION, $db_version );
		$upgrader->run();
	}

	/**
	 * Registers all hooks
	 */
	private function setup_hooks() {

		global $pagenow;
		$current_page = isset( $pagenow ) ? $pagenow : '';

		// Actions used globally throughout WP Admin
		add_action( 'admin_init', array( $this, 'initialize' ) );
		add_action( 'admin_menu', array( $this, 'build_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_css_and_js' ) );
		add_action( 'admin_footer_text', array( $this, 'footer_text' ) );

		// Hooks for Plugins overview page
		if( $current_page === 'plugins.php' ) {
			$this->plugin_file = plugin_basename( MC4WP_LITE_PLUGIN_FILE );

			add_filter( 'plugin_action_links_' . $this->plugin_file, array( $this, 'add_plugin_settings_link' ), 10, 2 );
			add_filter( 'plugin_row_meta', array( $this, 'add_plugin_meta_links'), 10, 2 );
		}

		// Hooks for Form settings page
		if( $this->get_current_page() === 'mailchimp-for-wp-form-settings' ) {
			add_filter( 'quicktags_settings', array( $this, 'set_quicktags_buttons' ), 10, 2 );
		}

		// hide major plugin updates for everyone
		add_filter( 'site_transient_update_plugins', array( $this, 'hide_major_plugin_updates' ) );
	}

	/**
	 * Prevents v3.x updates from showing
	 */
	public function hide_major_plugin_updates( $data ) {

		// do we have an update for this plugin?
		if( isset( $data->response[ $this->plugin_file ]->new_version ) ) {

			// check if this is a major update and if so, remove it from the response object
			if( version_compare( $data->response[ $this->plugin_file ]->new_version, '3.0.0', '>=' ) ) {
				unset( $data->response[ $this->plugin_file ] );
			}
		}

		// return modified updates data
		return $data;
	}

	/**
	 * Load the plugin translations
	 */
	private function load_translations() {
		// load the plugin text domain
		load_plugin_textdomain( 'mailchimp-for-wp', false, dirname( $this->plugin_file ) . '/languages' );
	}

	/**
	 * Initializes various stuff used in WP Admin
	 *
	 * - Registers settings
	 * - Checks if the Captcha plugin is activated
	 * - Loads the plugin text domain
	 */
	public function initialize() {

		// register settings
		register_setting( 'mc4wp_lite_settings', 'mc4wp_lite', array( $this, 'validate_settings' ) );
		register_setting( 'mc4wp_lite_checkbox_settings', 'mc4wp_lite_checkbox', array( $this, 'validate_settings' ) );
		register_setting( 'mc4wp_lite_form_settings', 'mc4wp_lite_form', array( $this, 'validate_settings' ) );

		// store whether this plugin has the BWS captcha plugin running (https://wordpress.org/plugins/captcha/)
		$this->has_captcha_plugin = function_exists( 'cptch_display_captcha_custom' );

		$this->load_upgrader();
	}

	/**
	 * Listen to various mc4wp actions
	 */
	private function listen() {
		// did the user click on upgrade to pro link?
		if( $this->get_current_page() === 'mailchimp-for-wp-upgrade' && false === headers_sent() ) {
			wp_redirect( 'https://mc4wp.com/#utm_source=wp-plugin&utm_medium=mailchimp-for-wp&utm_campaign=menu-upgrade-link' );
			exit;
		}
	}

	/**
	 * Set which Quicktag buttons should appear in the form mark-up editor
	 *
	 * @param array $settings
	 * @param string $editor_id
	 * @return array
	 */
	public function set_quicktags_buttons( $settings, $editor_id = '' )
	{
		if( $editor_id !== 'mc4wpformmarkup' ) {
			return $settings;
		}

		$settings['buttons'] = 'strong,em,link,img,ul,li,close';

		return $settings;
	}

	/**
	 * Add the settings link to the Plugins overview
	 *
	 * @param array $links
	 * @param       $file
	 *
	 * @return array
	 */
	public function add_plugin_settings_link( $links, $file ) {
		if( $file !== $this->plugin_file ) {
			return $links;
		}

		 $settings_link = '<a href="' . admin_url( 'admin.php?page=mailchimp-for-wp' ) . '">'. __( 'Settings', 'mailchimp-for-wp' ) . '</a>';
		 array_unshift( $links, $settings_link );
		 return $links;
	}

	/**
	 * Adds meta links to the plugin in the WP Admin > Plugins screen
	 *
	 * @param array $links
	 * @param string $file
	 *
	 * @return array
	 */
	public function add_plugin_meta_links( $links, $file ) {
		if( $file !== $this->plugin_file ) {
			return $links;
		}

		$links[] = '<a href="https://wordpress.org/plugins/mailchimp-for-wp/faq/">FAQ</a>';
		$links[] = '<a href="https://mc4wp.com/#utm_source=wp-plugin&utm_medium=mailchimp-for-wp&utm_campaign=plugins-upgrade-link">' . __( 'Upgrade to MailChimp for WordPress Pro', 'mailchimp-for-wp' ) . '</a>';
		return $links;
	}

	/**
	 * @return string
	 */
	public function get_required_capability() {

		/**
		 * @filter mc4wp_settings_cap
		 * @expects     string      A valid WP capability like 'manage_options' (default)
		 *
		 * Use to customize the required user capability to access the MC4WP settings pages
		 */
		$required_cap = (string) apply_filters( 'mc4wp_settings_cap', 'manage_options' );

		return $required_cap;
	}

	/**
	* Register the setting pages and their menu items
		*/
	public function build_menu() {

		$required_cap = $this->get_required_capability();

		$menu_items = array(
			array(
				'title' => __( 'MailChimp API Settings', 'mailchimp-for-wp' ),
				'text' => __( 'MailChimp', 'mailchimp-for-wp' ),
				'slug' => '',
				'callback' => array( $this, 'show_api_settings' ),
			),
			array(
				'title' => __( 'Checkbox Settings', 'mailchimp-for-wp' ),
				'text' => __( 'Checkboxes', 'mailchimp-for-wp' ),
				'slug' => 'checkbox-settings',
				'callback' => array( $this, 'show_checkbox_settings' ),
			),
			array(
				'title' => __( 'Form Settings', 'mailchimp-for-wp' ),
				'text' => __( 'Forms', 'mailchimp-for-wp' ),
				'slug' => 'form-settings',
				'callback' => array( $this, 'show_form_settings' ) ),
			array(
				'title' => __( 'Upgrade to Pro', 'mailchimp-for-wp' ),
				'text' => '<span style="line-height: 20px;"><span class="dashicons dashicons-external"></span> ' .__( 'Upgrade to Pro', 'mailchimp-for-wp' ),
				'slug' => 'upgrade',

				'callback' => array( $this, 'redirect_to_pro' ),
			),
		);

		$menu_items = apply_filters( 'mc4wp_menu_items', $menu_items );

		// add top menu item
		add_menu_page( 'MailChimp for WP Lite', 'MailChimp for WP', $required_cap, 'mailchimp-for-wp', array( $this, 'show_api_settings' ), MC4WP_LITE_PLUGIN_URL . 'assets/img/icon.png', '99.68491' );

		// add submenu pages
		foreach( $menu_items as $item ) {
			$slug = ( '' !== $item['slug'] ) ? "mailchimp-for-wp-{$item['slug']}" : 'mailchimp-for-wp';
			add_submenu_page( 'mailchimp-for-wp', $item['title'] . ' - MailChimp for WordPress Lite', $item['text'], $required_cap, $slug, $item['callback'] );
		}

	}


	/**
	* Validates the General settings
	*
	* @param array $settings
	* @return array
	*/
	public function validate_settings( array $settings ) {

		$current = mc4wp_get_options();

		// Toggle usage tracking
		if( isset( $settings['allow_usage_tracking'] ) ) {
			MC4WP_Usage_Tracking::instance()->toggle( (bool) $settings['allow_usage_tracking'] );
		}

		// sanitize simple text fields (no HTML, just chars & numbers)
		$simple_text_fields = array( 'api_key', 'redirect', 'css' );
		foreach( $simple_text_fields as $field ) {
			if( isset( $settings[ $field ] ) ) {
				$settings[ $field ] = sanitize_text_field( $settings[ $field ] );
			}
		}

		// if api key changed, empty cache
		if( isset( $settings['api_key'] ) && $settings['api_key'] !== $current['general']['api_key'] ) {
			$this->mailchimp->empty_cache();
		}

		// validate woocommerce checkbox position
		if( isset( $settings['woocommerce_position'] ) ) {
			// make sure position is either 'order' or 'billing'
			if( ! in_array( $settings['woocommerce_position'], array( 'order', 'billing' ) ) ) {
				$settings['woocommerce_position'] = 'billing';
			}
		}

		// dynamic sanitization
		foreach( $settings as $setting => $value ) {
			// strip special tags from text settings
			if( substr( $setting, 0, 5 ) === 'text_' || $setting === 'label' ) {
				$value = trim( $value );
				$value = strip_tags( $value, '<a><b><strong><em><i><br><u><script><span><abbr><strike>' );
				$settings[ $setting ] = $value;
			}
		}

		// strip <form> from form mark-up
		if( isset( $settings[ 'markup'] ) ) {
			$settings[ 'markup' ] = preg_replace( '/<\/?form(.|\s)*?>/i', '', $settings[ 'markup'] );
		}

		return $settings;
	}

	/**
	 * Load scripts and stylesheet on MailChimp for WP Admin pages
	 * @return bool
	*/
	public function load_css_and_js() {
		// only load asset files on the MailChimp for WordPress settings pages
		if( strpos( $this->get_current_page(), 'mailchimp-for-wp' ) !== 0 ) {
			return false;
		}

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// css
		wp_enqueue_style( 'mc4wp-admin-css', MC4WP_LITE_PLUGIN_URL . 'assets/css/admin' . $suffix . '.css' );

		// js
		wp_register_script( 'mc4wp-beautifyhtml', MC4WP_LITE_PLUGIN_URL . 'assets/js/third-party/beautify-html'. $suffix .'.js', array( 'jquery' ), MC4WP_LITE_VERSION, true );
		wp_register_script( 'mc4wp-admin', MC4WP_LITE_PLUGIN_URL . 'assets/js/admin' . $suffix . '.js', array( 'jquery', 'quicktags' ), MC4WP_LITE_VERSION, true );
		wp_enqueue_script( array( 'jquery', 'mc4wp-beautifyhtml', 'mc4wp-admin' ) );
		wp_localize_script( 'mc4wp-admin', 'mc4wp',
			array(
				'hasCaptchaPlugin' => $this->has_captcha_plugin,
				'strings' => array(
					'proOnlyNotice' => __( 'This option is only available in MailChimp for WordPress Pro.', 'mailchimp-for-wp' ),
					'fieldWizard' => array(
						'proOnly' => __( '(PRO ONLY)', 'mailchimp-for-wp' ),
						'buttonText' => __( 'Button text', 'mailchimp-for-wp' ),
						'initialValue' => __( 'Initial value', 'mailchimp-for-wp' ),
						'optional' => __( '(optional)', 'mailchimp-for-wp' ),
						'labelFor' => __( 'Label for', 'mailchimp-for-wp' ),
						'orLeaveEmpty' => __( '(or leave empty)', 'mailchimp-for-wp' ),
						'subscribe' => __( 'Subscribe', 'mailchimp-for-wp' ),
						'unsubscribe' => __( 'Unsubscribe', 'mailchimp-for-wp' ),
					)
				),
				'mailchimpLists' => $this->mailchimp->get_lists()
			)
		);

		return true;
	}

	/**
	 * Returns available checkbox integrations
	 *
	 * @return array
	 */
	public function get_checkbox_compatible_plugins()
	{
		static $checkbox_plugins;

		if( is_array( $checkbox_plugins ) ) {
			return $checkbox_plugins;
		}

		$checkbox_plugins = array(
			'comment_form' => __( 'Comment form', 'mailchimp-for-wp' ),
			'registration_form' => __( 'Registration form', 'mailchimp-for-wp' )
		);

		if( is_multisite() ) {
			$checkbox_plugins['multisite_form'] = __( 'MultiSite forms', 'mailchimp-for-wp' );
		}

		if( class_exists( 'BuddyPress' ) ) {
			$checkbox_plugins['buddypress_form'] = __( 'BuddyPress registration', 'mailchimp-for-wp' );
		}

		if( class_exists( 'bbPress' ) ) {
			$checkbox_plugins['bbpress_forms'] = 'bbPress';
		}

		if ( class_exists( 'WooCommerce' ) ) {
			$checkbox_plugins['woocommerce_checkout'] = sprintf( __( '%s checkout', 'mailchimp-for-wp' ), 'WooCommerce' );
		}

		if ( class_exists( 'Easy_Digital_Downloads' ) ) {
			$checkbox_plugins['edd_checkout'] = sprintf( __( '%s checkout', 'mailchimp-for-wp' ), 'Easy Digital Downloads' );
		}

		return $checkbox_plugins;
	}

	/**
	* Redirects to the premium version of MailChimp for WordPress (uses JS)
	*/
	public function redirect_to_pro()
	{
		?><script type="text/javascript">window.location.replace('https://mc4wp.com/#utm_source=wp-plugin&utm_medium=mailchimp-for-wp&utm_campaign=menu-upgrade-link'); </script><?php
	}

	/**
	* Show the API settings page
	*/
	public function show_api_settings()
	{
		$opts = mc4wp_get_options( 'general' );
		$connected = ( mc4wp_get_api()->is_connected() );

		// cache renewal triggered manually?
		$force_cache_refresh = isset( $_POST['mc4wp-renew-cache'] ) && $_POST['mc4wp-renew-cache'] == 1;
		$lists = $this->mailchimp->get_lists( $force_cache_refresh );

		if ( $force_cache_refresh ) {

			if( is_array( $lists ) ) {
				if( count( $lists ) === 100 ) {
					add_settings_error( 'mc4wp', 'mc4wp-lists-at-limit', __( 'The plugin can only fetch a maximum of 100 lists from MailChimp, only your first 100 lists are shown.', 'mailchimp-for-wp' ) );
				} else {
					add_settings_error( 'mc4wp', 'mc4wp-cache-success', __( 'Renewed MailChimp cache.', 'mailchimp-for-wp' ), 'updated' );
				}
			} else {
				add_settings_error( 'mc4wp', 'mc4wp-cache-error', __( 'Failed to renew MailChimp cache - please try again later.', 'mailchimp-for-wp' ) );
			}

		}

		require MC4WP_LITE_PLUGIN_DIR . 'includes/views/api-settings.php';
	}

	/**
	* Show the Checkbox settings page
	*/
	public function show_checkbox_settings()
	{
		$opts = mc4wp_get_options( 'checkbox' );
		$lists = $this->mailchimp->get_lists();
		require MC4WP_LITE_PLUGIN_DIR . 'includes/views/checkbox-settings.php';
	}

	/**
	* Show the forms settings page
	*/
	public function show_form_settings()
	{
		$opts = mc4wp_get_options( 'form' );
		$lists = $this->mailchimp->get_lists();

		require MC4WP_LITE_PLUGIN_DIR . 'includes/views/form-settings.php';
	}

	/**
	 * @return string
	 */
	protected function get_current_page() {
		return isset( $_GET['page'] ) ? $_GET['page'] : '';
	}

	/**
	 * Ask for a plugin review in the WP Admin footer, if this is one of the plugin pages.
	 *
	 * @param $text
	 *
	 * @return string
	 */
	public function footer_text( $text ) {

		if( isset( $_GET['page'] ) && strpos( $_GET['page'], 'mailchimp-for-wp' ) === 0 ) {
			$text = sprintf( 'If you enjoy using <strong>MailChimp for WordPress</strong>, please <a href="%s" target="_blank">leave us a ★★★★★ rating</a>. A <strong style="text-decoration: underline;">huge</strong> thank you in advance!', 'https://wordpress.org/support/view/plugin-reviews/mailchimp-for-wp?rate=5#postform' );
		}

		return $text;
	}

}
<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://apisearch.io
 * @since      1.0.0
 *
 * @package    Apisearch
 * @subpackage Apisearch/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Apisearch
 * @subpackage Apisearch/admin
 * @author     Apisearch Team <hello+plugin+wordpress@puntmig.com>
 */
class Apisearch_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
     * Stored options
     *
     * @var array
     */
    private $stored_options;

    /**
     * Apisearch client
     *
     * @var ApisearchClient
     */
    private $apisearchClient;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->stored_options = get_option($this->plugin_name);
        $this->apisearchClient = new ApisearchClient('https://apisearch.global.ssl.fastly.net', 'v1');
        if ($this->checkStoredConfig()) {
            $this->apisearchClient->setCredentials(
                $this->stored_options['app_id'],
                $this->stored_options['index_id'],
                $this->stored_options['admin_token']
            );
        }

        include_once('class-apisearch-admin-settings.php');
        include_once('class-apisearch-admin-search.php');
        include_once('class-apisearch-admin-metrics.php');
        include_once('class-apisearch-admin-api.php');
        include_once('class-apisearch-admin-meta.php');
		include_once('transformers/post-transformer.php');
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Apisearch_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Apisearch_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style(
		    $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/apisearch-admin.css',
            array(),
            $this->version,
            'all'
        );

		wp_enqueue_style(
		    'flexboxgrid',
            '//cdnjs.cloudflare.com/ajax/libs/flexboxgrid/6.3.1/flexboxgrid.min.css'
        );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Apisearch_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Apisearch_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script(
		    $this->plugin_name . '-admin',
            plugin_dir_url( __FILE__ ) . 'js/apisearch-admin.js',
            array( 'jquery' ),
            $this->version,
            false
        );

		wp_enqueue_script(
		    $this->plugin_name . '-graphs-admin',
            plugin_dir_url( __FILE__ ) . 'js/apisearch-graphs-admin.js',
            array( 'jquery' ),
            $this->version,
            false
        );

        wp_localize_script(
		    $this->plugin_name . '-graphs-admin',
            'php_vars',
            $this->stored_options
        );
	}

	/**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        add_menu_page(
            'Settings',
            __('Apisearch', $this->plugin_name),
            'manage_options',
            'apisearch',
            function() {ApisearchAdminSettings::show($this->plugin_name);},
            plugins_url('apisearch/public/images/icon.png')
        );

        add_submenu_page(
			'apisearch',
			__('Search', $this->plugin_name),
			__('Search', $this->plugin_name),
            'manage_options',
            'apisearch-search',
			function() {
			    ApisearchAdminSearch::show(
                    $this->plugin_name,
                    $this->stored_options
                );
			}
		);

        add_submenu_page(
			'apisearch',
			__('Metrics', $this->plugin_name),
			__('Metrics', $this->plugin_name),
            'manage_options',
            'apisearch-settings',
			function() {
			    ApisearchAdminMetrics::show(
                    $this->plugin_name,
                    $this->stored_options
                );
			}
		);
    }

     /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function add_action_links( $links ) {
        /*
        *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
        */
       $settings_link = array(
        '<a href="' . admin_url( 'admin.php?page=apisearch') . '">' . __('Settings', $this->plugin_name) . '</a>',
       );
       return array_merge(  $settings_link, $links );
    }

	/**
	*
	* admin/class-wp-cbf-admin.php
	*
	**/
	public function options_update() {
		register_setting(
			$this->plugin_name,
			$this->plugin_name,
			function($input) {return ApisearchAdminSettings::validate($input);}
		);
	}

   /**
	* Save a post
	*
	* @param string $postId
	* @param WP_Post $post
	*/
	public function savePost(
		$postId,
		WP_Post $post
	) {
		if(!current_user_can("edit_post", $postId)) {
			return;
		}

		if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
			return;
		}

		$postAsArray = $post->to_array();
		ApisearchAdminMeta::saveMetadata(
			$postId,
			$postAsArray
		);

		if (!$this->checkStoredConfig()) {
			return;
		}

		ApisearchAdminApi::indexPost(
			$this->apisearchClient,
			$postId,
			$postAsArray
		);

		$this->flushClient();
	}

	/**
	 * Add meta boxes
	 */
	public function addMetaBoxes()
	{
		add_meta_box(
			$this->plugin_name . '_metadata',
			'Search metadata',
			function($object) {
				ApisearchAdminMeta::showMetadata($object);
			},
			['post', 'page'],
			'side',
			'default',
			null
		);
	}

	/**
	 * Index all posts
	 */
	public function indexAll()
	{
		$this->apisearchClient->resetIndex();
		$posts = get_posts([
			'post_status' => 'publish',
			'numberposts' => -1
		]);
		foreach ($posts as $post) {
			$postAsArray = $post->to_array();
			ApisearchAdminApi::indexPost(
				$this->apisearchClient,
				$postAsArray['ID'],
				$postAsArray
			);
		}

		$this->flushClient();

		wp_send_json_success('Posts indexed properly');
		die(1);
	}

    /**
     * Display notices
     */
    public function displayNotices()
    {
        if (isset($_GET['credentials_verified'])) {
            if ($_GET['credentials_verified'] == 1) {
                ?>
                    <div class="notice notice-success is-dismissible">
                        <p><strong><?php _e( 'Congratulations! Your settings have been verified!', 'my_plugin_textdomain' ); ?></strong></p>
                    </div>
                <?php
            } else {
                ?>
                    <div class="notice notice-error is-dismissible">
                        <p><strong><?php _e( 'We couldn\'t verify your credentials. Please, check that they are valid.', 'my_plugin_textdomain' ); ?></strong></p>
                    </div>
                <?php
            }
        }
    }

    /**
     * Check options
     */
    private function checkStoredConfig()
    {
        return
            !empty($this->stored_options['app_id']) &&
            !empty($this->stored_options['index_id']) &&
            !empty($this->stored_options['admin_token']);
    }

    /**
	 * Flush client
	 */
    private function flushClient()
	{
		$this
			->apisearchClient
			->flush();
	}
}

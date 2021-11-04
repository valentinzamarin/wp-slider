<?php

class Wps_Admin {

	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function plugin_admin_page() {
		
		add_menu_page(
			'WP Slider',
			'WP Slider',
			'manage_options',
			'wp-slider',
			array(
				$this,
				'plugin_admin_display',
			)
		);

	}

	public function plugin_admin_display() {

		include WPS_PLUGIN_DIR . '/admin/partials/wps-admin-display.php';

	}

	public function plugin_admin_optins() {

		$args = [
			'default' => 3,
		];
		register_setting( 'wps-settings', 'wps_count', $args );
		
	}

	public function plugin_refresh_list() {
		check_ajax_referer( 'wps-nonce' );
		
		global $wpdb;
		$table_name = WPS_PLUGIN_TABLE;
		$wpdb->query("DELETE FROM $table_name");

		$list = json_decode( stripslashes( $_POST['list'] ) );

		foreach(  $list as $item ) {
			$wpdb->insert(
				WPS_PLUGIN_TABLE,
				[
					'idx'         => $item->idx,
					'title'       => $item->title,
					'description' => $item->descr,
					'link'        => $item->link,
					'image'       => $item->img,
				]
			);
		}
		wp_send_json_success();
	}

	public function plugin_add_slider() {
		check_ajax_referer( 'wps-nonce' );

		require_once( ABSPATH . 'wp-admin/includes/file.php' );  
		
		$index = stripslashes( $_POST['idx'] );
		$name  = stripslashes( $_POST['name'] );
		$descr = stripslashes( $_POST['descr'] );
		$link  = stripslashes( $_POST['link'] );
		
		if ( isset( $_FILES['image'] ) ) {
			$upload_dir = wp_upload_dir();
	 
			if ( ! empty( $upload_dir['basedir'] ) ) {
				$user_dirname = $upload_dir['basedir'] . '/' . WPS_PLUGIN_FOLDER;
				if ( ! file_exists( $user_dirname ) ) {
					wp_mkdir_p( $user_dirname );
				}
				$filename = wp_unique_filename( $user_dirname, $_FILES['image']['name'] );
				move_uploaded_file( $_FILES['image']['tmp_name'], $user_dirname .'/'. $filename);
				$filepath = $upload_dir['baseurl'] .'/' . WPS_PLUGIN_FOLDER . '/'. $filename;
			}
		}

		global $wpdb;

		$wpdb->insert(
			WPS_PLUGIN_TABLE,
			[
				'idx'         => $index,
				'title'       => $name,
				'description' => $descr,
				'link'        => $link,
				'image'       => $filepath,
			]
		);
		wp_send_json_success();
		
	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wps-admin.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wps-admin.js', array( 'jquery', 'jquery-ui-sortable' ), $this->version, true );
		wp_localize_script(
			$this->plugin_name,
			'wps_ajax',
			[
				'nonce' => wp_create_nonce( 'wps-nonce' ),
				'url'   => admin_url( 'admin-ajax.php' ),
			]
		);

	}

}

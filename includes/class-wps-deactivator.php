<?php

class Wps_Deactivator {

	public static function deactivate() {

		global $wpdb;
		$table_name = WPS_PLUGIN_TABLE;
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query($sql);

		$upload_dir = wp_upload_dir();
		$plugin_folder = $upload_dir['basedir']. '/' . WPS_PLUGIN_FOLDER;

		global $wp_filesystem;
		$wp_filesystem->delete( $plugin_folder, true );
		
		delete_option( 'wps_count' );
	}

}

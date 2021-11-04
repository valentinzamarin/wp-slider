<?php
class Wps_Activator {
	public static function activate() {

		global $wpdb;
		$table_name = WPS_PLUGIN_TABLE;
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			idx int(3) NOT NULL,
			title longtext NOT NULL,
			description longtext NOT NULL,
			link longtext NOT NULL,
			image longtext NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate";
		require_once( ABSPATH .'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		

	}
}

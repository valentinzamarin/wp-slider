<?php
global $wpdb;
$table_name = WPS_PLUGIN_TABLE;
$slides     = $wpdb->get_results("SELECT * FROM $table_name");

?>
<div>
    <h1>
        <?php echo esc_html( get_admin_page_title() ); ?>
    </h1>
    <form id="wps-form" enctype="multipart/form-data">
        <input type="text" name="name" required placeholder="title" />
        <input type="text" name="descr" required placeholder="descr" />
        <input type="text" name="link" required placeholder="link" />
        <input type="file" name="image" required />
        <input type="submit" class="button button-primary">
    </form>

    <div class="wps-slides">
        <div class="wps-slides__head">
            <div class="wps-slides__col wps-slides__center">
                Index
            </div>
            <div class="wps-slides__col">
                title
            </div>
            <div class="wps-slides__col">
                description
            </div>
            <div class="wps-slides__col">
                Url
            </div>
            <div class="wps-slides__col">
                image
            </div>
        </div>
        <div class="wps-slides__list">
            <?php
            foreach ( $slides as $index => $slide ) { ?>
                <div class="wps-slides__item">
                    <div class="wps-slides__col wps-slides__center">
                        <p class="wps-slides__index">
                            <?php echo esc_html( $index ); ?>
                        </p>
                    </div>
                    <div class="wps-slides__col">
                        <p class="wps-slides__title"> 
                            <?php echo esc_html( $slide->title ); ?>
                        </p>
                    </div>
                    <div class="wps-slides__col">
                        <p class="wps-slides__descr">
                            <?php echo esc_html( $slide->description ); ?>
                        </p>
                    </div>
                    <div class="wps-slides__col">
                        <p class="wps-slides__link">
                            <?php echo esc_url( $slide->link ); ?>
                        </p>
                    </div>
                    <div class="wps-slides__col">
                        <picture>
                            <img class="wps-slides__img" src="<?php echo esc_url( $slide->image ); ?>" alt="<?php echo esc_html( $slide->title ); ?>">
                        </picture>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <form method="post" action="options.php">
		<?php
			settings_fields( 'wps-settings' );
			do_settings_sections( 'wps-settings' );
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Кол-во слайдов</th>
				<td>
					<input type="number" name="wps_count" value="<?php echo esc_attr( get_option( 'wps_count' ) ); ?>" />
				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>

</div>
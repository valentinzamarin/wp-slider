<?php

global $wpdb;
$table_name = WPS_PLUGIN_TABLE;
$slides     = $wpdb->get_results( "SELECT * FROM $table_name" );
$count      = get_option( 'wps_count' );
if( !$count ) {
  update_option('wps_count', 3 );
}
?>
<div class="swiper">
  <div class="swiper-wrapper">
    <?php
    $idx = 1;
    foreach( $slides as $slide ) { 
    ?>
        <div class="swiper-slide" style="background-image: url(<?php echo esc_url( $slide->image ); ?>);">
            <h2>
                <?php echo esc_html( $slide->title ); ?>
            </h2>
            <p>
                <?php echo esc_html( $slide->description ); ?>
            </p>
            <a href="<?php echo esc_url( $slide->link ); ?>">Link</a>
        </div>
    <?php 
      if( $idx === intval( $count ) ) {
        break;
      }
      $idx++;
      } 
    ?>
  </div>

  <div class="swiper-pagination"></div>
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
  <div class="swiper-scrollbar"></div>
</div>	

		
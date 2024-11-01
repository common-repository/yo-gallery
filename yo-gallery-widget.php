<?php
/*  
 * YO Gallery
 * Version:           1.0.0 - 32132
 * Author:            Yo Gallery Team (YGT)
 * Date:              05/05/2018
 */

class YoGalleryWidget extends WP_Widget {

  function __construct(){
  		global $pagenow;
 		if( isset( $pagenow) &&  ( $pagenow=='customize.php' || $pagenow=='widgets.php' ) ) {
  			wp_enqueue_media();
			wp_enqueue_style('wp-jquery-ui-dialog');
			wp_enqueue_script('jquery-ui-dialog');
		}
	    parent::__construct(
	      'YoGalleryWidget',
	      __( 'Yo Gallery Widget', 'yo-gallery' ),
	      array( 'description' => __( "Publish Yo Gallery on your website.", 'yo-gallery' ), )
	    );
  }

  public function widget( $args, $instance ) {

	wp_enqueue_script( 'yo-gallery-lightbox-js',YO_GALLERY_URL.'assets/js/swipebox.lightbox.js', 	array( 'jquery' ), 					YO_GALLERY_VERSION, false );
	wp_enqueue_script( 'yo-gallery-script-js', 	YO_GALLERY_URL.'assets/js/script.js', 				array( 'yo-gallery-lightbox-js' ), 	YO_GALLERY_VERSION, false );
	wp_enqueue_style(  'yo-gallery-style-css',	YO_GALLERY_URL.'assets/css/swipebox.style.css', 	array(), 							YO_GALLERY_VERSION, 'all' );

    $title = apply_filters( 'widget_title', $instance['title'] );
    $galleries_id = $instance['galleries_id'];
	$columns = $instance['columns'];
	if(!$columns) $columns = 3;
	$lightbox = $instance['lightbox'];

    echo $args['before_widget'];
    if( ! empty( $title ) )     echo $args['before_title'] . $title . $args['after_title'];

    echo '<div id="'.uniqid('yo_gallery_block_id_').'" class="yo-gallery-block" '.($lightbox?' data-hidecaption="1" ':'').'>';
   		echo do_shortcode('[gallery ids="'.$galleries_id.'" link="file"  columns="'.$columns.'" ]');
   	echo '</div>';

    echo $args['after_widget'];
  }


  public function form( $instance ) {

	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	} else {
		$title = __( 'Images', 'yo-gallery' );
	}

    if ( isset( $instance[ 'galleries_id' ] ) ) {
      	$galleries_id = $instance[ 'galleries_id' ];
    } else {
      	$galleries_id = ' ';
    }

     if ( isset( $instance[ 'columns' ] ) ) {
      	$columns = $instance[ 'columns' ];
    } else {
      	$columns = 3;
    }

    if ( isset( $instance[ 'lightbox' ] ) ) {
      	$lightbox = $instance[ 'lightbox' ];
    } else $lightbox = '';

    ?>
    <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">
	 		<?php _e( 'Title' ); ?>:
		</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	
	<p align="center">
		<?php _e( 'Use manage images button to select pictures for your photo gallery' ); ?>:
	</p>

	<p align="center">

    	<button data-valuefield="<?php echo $this->get_field_id( 'galleries_id' ); ?>" class="button yo-gallery-edit-button"><?php _e( 'Manage Images' ); ?></button>
   		<input type='hidden' id="<?php echo $this->get_field_id( 'galleries_id' ); ?>" name="<?php echo $this->get_field_name( 'galleries_id' ); ?>" value="<?php echo esc_attr( $galleries_id ); ?>" />
	<p>

	<p>
		<label for="<?php echo $this->get_field_id( 'columns' ); ?>"><?php _e( 'Columns:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'columns' ); ?>" name="<?php echo $this->get_field_name( 'columns' ); ?>" class="tiny-text" step="1" min="1" size="3" type="number"  value="<?php echo $columns; ?>" />
	</p>

	<p>
		<input <?php checked( $lightbox , 'on' ); ?> value='on' id="<?php echo $this->get_field_id( 'lightbox' ); ?>" name="<?php echo $this->get_field_name( 'lightbox' ); ?>" type="checkbox" >
		<label for="<?php echo $this->get_field_id( 'lightbox' ); ?>"><?php _e( 'Disable Caption', 'yo-gallery' ); ?></label>
	</p>

	<script type="text/javascript">
		(function ($) {
    		$('.yo-gallery-edit-button').click(function(event){
    			event.preventDefault();
    			var valField = $( '#'+$(this).data("valuefield") );
    			wp.media.gallery.edit("[gallery ids='"+valField.val()+"']").on('update', function(g){
					var id_array = [];
					$.each(g.models, function(id, img) { id_array.push(img.id); });
					valField.val(id_array.join(","));
				});
    			if(valField.val()=='' || valField.val()==' ') $('.media-frame-menu .media-menu-item').eq(2).click();
    		});
    	}(jQuery));

	</script>

    <?php
  }

  public function update( $new_instance, $old_instance ) {
	$instance = array();
	$instance['title'] = 		( ! empty( $new_instance['title'] ) ) 		? strip_tags( $new_instance['title'] ) : '';
	$instance['columns'] = 		( ! empty( $new_instance['columns'] ) ) 	? (int) $new_instance['columns'] : 3;
	$instance['lightbox'] = 	$new_instance['lightbox'];
	$instance['galleries_id'] = ( ! empty( $new_instance['galleries_id'] ) ) ? strip_tags($new_instance['galleries_id']) :  ' ';
	return $instance;
  }
}


function widget_init_function_yo_gallery() {
  	register_widget( 'YoGalleryWidget' );
}

add_action( 'widgets_init', 'widget_init_function_yo_gallery' );

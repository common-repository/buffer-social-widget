<?php 
/*
Facebook like box widget class
*/

class TB_Facebook_Like_Box_Widget extends WP_Widget{
	
	public function __construct(){
		parent::__construct('tb_facebook_like_box', /* Unique widget ID */
			esc_html__('Buffer Facebook Like Box', 'tb-social-widget'), /* Widget title display in widget area. */
			array( 'description' => esc_html__( 'Display your facebook page activities in like box.', 'tb-social-widget' ), ) 
			/* Widget description */
		);
	}
	
	/************************************************************/
	## facebook code after 
	/*************************************************************/
	
	public function tb_facebook_code(){
		
		echo '<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, \'script\', \'facebook-jssdk\'));</script>';
		
	}
	
	/**********************************************/
	## Creating widget front-end
	## This is where the action happens 
	/*********************************************/
	public function widget( $args, $instance ) {
		
		$title               = isset($instance['title'] ) ? $instance['title'] : '';
		$tb_fb_page_url     = $instance['tb_fb_page_url'] ? $instance['tb_fb_page_url'] : '';
		$tb_fb_width        = $instance['tb_fb_width'] ? $instance['tb_fb_width'] : '';
		$tb_fb_height       = $instance['tb_fb_height'] ? $instance['tb_fb_height'] : '';
		$tb_fb_hide_cover   = $instance['tb_fb_hide_cover'] ? $instance['tb_fb_hide_cover'] : '';
		$tb_fb_show_post    = $instance['tb_fb_show_post'] ? $instance['tb_fb_show_post'] : '';
		$tb_fb_profile_pic  = $instance['tb_fb_profile_pic'] ? $instance['tb_fb_profile_pic'] : '';
		$tb_fb_small_header = $instance['tb_fb_small_header'] ? $instance['tb_fb_small_header'] : '';
		$tb_fb_adapt_width  = $instance['tb_fb_adapt_width'] ? $instance['tb_fb_adapt_width'] : '';
		$tb_fb_hide_cta     = $instance['tb_fb_hide_cta'] ? $instance['tb_fb_hide_cta'] : '';
		
		echo $args['before_widget']; /* before and after widget arguments are defined by themes */
		if($title != '')
		echo $args['before_title'] . $title . $args['after_title'];
		
		/* This is where you run the code and display the output */
		
		if($tb_fb_page_url != ''){
			add_action( 'wp_footer', array($this,'tb_facebook_code') ); 
			echo '<div class="fb-page" data-href="'.$tb_fb_page_url.'" ';
			
			if($tb_fb_width != '') 
				echo 'data-width="'.$tb_fb_width.'" '; 
				
			if($tb_fb_height != '') 
				echo 'data-height="'.$tb_fb_height.'"'; 
				
			if($tb_fb_hide_cover == 'yes') 
				echo 'data-hide-cover="true"'; 
			else 
				echo 'data-hide-cover="false"';
				
			if($tb_fb_show_post == 'yes') 
				echo 'data-show-posts="true"';
			else 
				echo 'data-show-posts="false"';
				
			if($tb_fb_profile_pic == 'yes') 
				echo 'data-show-facepile="true"'; 
			else 
				echo 'data-show-facepile="false" ';
			
			if($tb_fb_small_header == 'yes') 
				echo 'data-small-header = "true"'; 
			else 
				echo 'data-small-header ="false" ';
				
			if($tb_fb_adapt_width == 'yes') 
				echo 'data-adapt-container-width = "true"'; 
			else 
				echo 'data-adapt-container-width ="false" ';
				
			if($tb_fb_hide_cta == 'yes') 
				echo 'data-hide-cta = "true"'; 
			else 
				echo 'data-hide-cta ="false" ';
				
			echo '></div>';
		}	
		echo $args['after_widget'];
	}
	
	/****************************************/
	## Widget Backend 
	/****************************************/
	
	public function form( $instance ) {
		
		$title               = isset( $instance[ 'title' ] ) ? esc_attr($instance[ 'title' ]) : '';
		$tb_fb_page_url     = isset( $instance[ 'tb_fb_page_url' ] ) ? esc_url($instance[ 'tb_fb_page_url' ]) : '';
		$tb_fb_profile_pic  = isset( $instance[ 'tb_fb_profile_pic' ] ) ? esc_attr($instance[ 'tb_fb_profile_pic' ]) : '';
		$tb_fb_show_post    = isset( $instance[ 'tb_fb_show_post' ] ) ? esc_attr($instance[ 'tb_fb_show_post' ]) : '';
		$tb_fb_hide_cover   = isset( $instance[ 'tb_fb_hide_cover' ] ) ? esc_attr($instance[ 'tb_fb_hide_cover' ]) : '';
		$tb_fb_hide_cta     = isset( $instance[ 'tb_fb_hide_cta' ] ) ? esc_attr($instance[ 'tb_fb_hide_cta' ]) : '';
		$tb_fb_small_header = isset( $instance[ 'tb_fb_small_header' ] ) ? esc_attr($instance[ 'tb_fb_small_header']) : '';
		$tb_fb_adapt_width  = isset( $instance[ 'tb_fb_adapt_width' ] ) ? esc_attr($instance['tb_fb_adapt_width']) : '';
		$tb_fb_width        = isset($instance[ 'tb_fb_width' ] ) ? esc_attr($instance[ 'tb_fb_width' ]) : '';
		$tb_fb_height       = isset($instance[ 'tb_fb_height' ]) ? esc_attr($instance[ 'tb_fb_height']) : '';
		
		/* Widget admin form */
	?>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title') ); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_fb_page_url') ); ?>"><?php esc_html_e( 'URL', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_fb_page_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_fb_page_url' )); ?>" type="text" value="<?php echo $tb_fb_page_url; ?>" />
	</p>
	
	<p>
		
		<input class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'tb_fb_profile_pic' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_fb_profile_pic' )); ?>" type="checkbox" value="yes"  <?php if($tb_fb_profile_pic == 'yes') echo 'checked'; ?> />
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_fb_profile_pic' )); ?>"><?php esc_html_e( 'Show Friend\'s Faces.', 'tb-social-widget' ); ?></label> <br/>
		
		<input class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'tb_fb_show_post' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_fb_show_post' )); ?>" type="checkbox" value="yes" <?php if($tb_fb_show_post == 'yes') echo 'checked'; ?> />
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_fb_show_post' )); ?>"><?php esc_html_e( 'Show Page Posts' , 'tb-social-widget'); ?></label> <br/>
		
		<input class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'tb_fb_hide_cover' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_fb_hide_cover' )); ?>" type="checkbox" value="yes" <?php if($tb_fb_hide_cover == 'yes') echo 'checked'; ?> />
		
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_fb_hide_cover') ); ?>"><?php esc_html_e('Hide Cover Photo' , 'tb-social-widget'); ?></label> <br/>
		
		<input class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'tb_fb_hide_cta') ); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_fb_hide_cta' )); ?>" type="checkbox" value="yes" <?php if($tb_fb_hide_cta == 'yes') echo 'checked'; ?> />
		
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_fb_hide_cta' )); ?>"><?php esc_html_e('Hide the custom call to action button (if available)', 'tb-social-widget' ); ?></label> <br/>
		
		<input class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'tb_fb_small_header' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_fb_small_header' )); ?>" type="checkbox" value="yes" <?php if($tb_fb_small_header  == 'yes') echo 'checked'; ?> />
		
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_fb_small_header' )); ?>"><?php esc_html_e('Use the small header instead', 'tb-social-widget' ); ?></label><br/>
		
		<input class="checkbox" id="<?php echo esc_attr($this->get_field_id( 'tb_fb_adapt_width' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_fb_adapt_width' )); ?>" type="checkbox" value="yes" <?php if($tb_fb_adapt_width == 'yes') echo 'checked'; ?> />
		
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_fb_adapt_width' )); ?>"><?php esc_html_e('Adapt to plugin container width', 'tb-social-widget' ); ?></label><br/>
		
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_fb_width' )); ?>"><?php esc_html_e( 'Width', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_fb_width' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_fb_width' )); ?>" type="text" value="<?php echo $tb_fb_width; ?>" /><?php esc_html_e( 'Pixels', 'tb-social-widget' ); ?>
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_fb_height' )); ?>"><?php esc_html_e( 'Height', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_fb_height' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_fb_height' )); ?>" type="text" value="<?php echo $tb_fb_height; ?>" /><?php esc_html_e( 'Pixels', 'tb-social-widget' ); ?>
	</p>
	
	<?php }
	
	
	/**********************************************************/
	## Updating widget replacing old instances with new.
	/**********************************************************/
	
	public function update( $new_instance, $old_instance ) {
	
		$instance = array();
		$instance['title'] = isset( $new_instance['title'] ) ? esc_attr( $new_instance['title'] ) : '';
		
		$instance['tb_fb_page_url'] = isset( $new_instance['tb_fb_page_url'] ) ? esc_attr( $new_instance['tb_fb_page_url'] ) : '';
		
		$instance['tb_fb_profile_pic'] = isset( $new_instance['tb_fb_profile_pic'] ) ? esc_attr( $new_instance['tb_fb_profile_pic'] ) : '';
		
		$instance['tb_fb_show_post'] = isset( $new_instance['tb_fb_show_post'] ) ? esc_attr( $new_instance['tb_fb_show_post'] ) : '';
		
		$instance['tb_fb_hide_cover'] = isset( $new_instance['tb_fb_hide_cover'] ) ? esc_attr( $new_instance['tb_fb_hide_cover'] ) : '';
		
		$instance['tb_fb_hide_cta'] = isset( $new_instance['tb_fb_hide_cta'] ) ? esc_attr( $new_instance['tb_fb_hide_cta'] ) : '';
		
		$instance['tb_fb_small_header'] = isset( $new_instance['tb_fb_small_header'] ) ? esc_attr( $new_instance['tb_fb_small_header'] ) : '';
		
		$instance['tb_fb_adapt_width'] = isset( $new_instance['tb_fb_adapt_width'] ) ? esc_attr( $new_instance['tb_fb_adapt_width'] ) : '';
		
		$instance['tb_fb_width'] = isset( $new_instance['tb_fb_width'] ) ? esc_attr( $new_instance['tb_fb_width'] ) : '';
		
		$instance['tb_fb_height'] = isset( $new_instance['tb_fb_height'] ) ? esc_attr( $new_instance['tb_fb_height'] ) : '';
		
		return $instance;
	}
	
}
// class end
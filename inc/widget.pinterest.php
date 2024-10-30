<?php 
/*
pinterest board widget class
*/

class TB_Pinterest_Board_Widget extends WP_Widget{
	
	public function __construct(){
		parent::__construct('tb_pinterest_board', /* Unique widget ID */
			esc_html__('Buffer Pinterest Board', 'tb-social-widget'), /* Widget title display in widget area. */
			array( 'description' => esc_html__( 'Display pinterest pin board.', 'tb-social-widget' ), ) 
			/* Widget description */
		);
	}
	
	/************************************************************/
	## linkedin script code 
	/*************************************************************/
	
	public function tb_pinterest_code(){
		echo '<script async defer src="//assets.pinterest.com/js/pinit.js"></script>';
	}
	
	/**********************************************/
	## Creating widget front-end
	## This is where the action happens 
	/*********************************************/
	
	public function widget($args, $instance){
		
		$title                     = isset($instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$tb_pinterest_borad_type   = $instance['tb_pinterest_borad_type'] ? $instance['tb_pinterest_borad_type'] : 'embedUser';
		$tb_pinterest_url          = $instance['tb_pinterest_url'] ? $instance['tb_pinterest_url'] : '';
		$tb_pinterest_board_image_size   = $instance['tb_pinterest_board_image_size'] ? $instance['tb_pinterest_board_image_size'] : 'top';
		$tb_pinterest_board_width  = $instance['tb_pinterest_board_width'] ? $instance['tb_pinterest_board_width'] : '';
		$tb_pinterest_board_height = $instance['tb_pinterest_board_height'] ? $instance['tb_pinterest_board_height'] : '';
		
		echo $args['before_widget']; /* before and after widget arguments are defined by themes */
		if($title != '')
		echo $args['before_title'] . $title . $args['after_title'];
		
		/* This is where you run the code and display the output */
	
		if($tb_pinterest_url != ''){
			add_action( 'wp_footer', array($this,'tb_pinterest_code') ); 
			echo '<a data-pin-do="'.$tb_pinterest_borad_type.'"';
			
			if($tb_pinterest_board_width != '') 
				echo 'data-pin-board-width="'.$tb_pinterest_board_width.'" '; 
				
			if($tb_pinterest_board_height != '') 
				echo 'data-pin-scale-height="'.$tb_pinterest_board_height.'"'; 
			
			if($tb_pinterest_board_image_size != '') 
				echo 'data-pin-scale-width="'.$tb_pinterest_board_image_size.'"'; 

			echo 'href="'.$tb_pinterest_url.'"></a>';
		}
		echo $args['after_widget'];
	}
	
	/****************************************/
	## Widget Backend 
	/****************************************/
	
	public function form( $instance ) {
		
		$title  = isset( $instance[ 'title' ] ) ? esc_attr($instance[ 'title' ]) : '';
		$tb_pinterest_borad_type  = isset( $instance[ 'tb_pinterest_borad_type' ] ) ? esc_attr($instance[ 'tb_pinterest_borad_type' ]) : '';
		$tb_pinterest_url  = isset( $instance[ 'tb_pinterest_url' ] ) ? esc_attr($instance[ 'tb_pinterest_url' ]) : '';
		$tb_pinterest_board_image_size  = isset( $instance[ 'tb_pinterest_board_image_size' ] ) ? esc_attr($instance[ 'tb_pinterest_board_image_size' ]) : '';
		$tb_pinterest_board_width        = isset($instance[ 'tb_pinterest_board_width' ] ) ? esc_attr($instance[ 'tb_pinterest_board_width' ]) : '';
		$tb_pinterest_board_height       = isset($instance[ 'tb_pinterest_board_height' ]) ? esc_attr($instance[ 'tb_pinterest_board_height']) : '';
		
		/* Widget admin form */
	?>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title') ); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_pinterest_borad_type') ); ?>"><?php esc_html_e( 'Board Type', 'tb-social-widget' ); ?></label> 
		
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_pinterest_borad_type' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_pinterest_borad_type' )); ?>">
	
			<option value="embedUser" <?php echo $tb_pinterest_borad_type == 'embedUser' ? 'selected': ''; ?>><?php esc_html_e( 'Embed Profile', 'tb-social-widget' ); ?></option>
			<option value="embedBoard" <?php echo $tb_pinterest_borad_type == 'embedBoard' ? 'selected': ''; ?>><?php esc_html_e( 'Embed Board', 'tb-social-widget' ); ?></option>
			
		</select>
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_pinterest_url') ); ?>"><?php esc_html_e( 'Profile/Board URL', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_pinterest_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_pinterest_url' )); ?>" type="text" value="<?php echo $tb_pinterest_url; ?>" />
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_pinterest_board_image_size') ); ?>"><?php esc_html_e( 'Board Image Size', 'tb-social-widget' ); ?></label> 
		
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_pinterest_board_image_size' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_pinterest_board_image_size' )); ?>" type="text" value="<?php echo $tb_pinterest_board_image_size; ?>" /><?php esc_html_e( 'Pixels', 'tb-social-widget' ); ?>
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_pinterest_board_width' )); ?>"><?php esc_html_e( 'Width', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_pinterest_board_width' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_pinterest_board_width' )); ?>" type="text" value="<?php echo $tb_pinterest_board_width; ?>" /><?php esc_html_e( 'Pixels', 'tb-social-widget' ); ?>
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_pinterest_board_height' )); ?>"><?php esc_html_e( 'Height', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_pinterest_board_height' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_pinterest_board_height' )); ?>" type="text" value="<?php echo $tb_pinterest_board_height; ?>" /><?php esc_html_e( 'Pixels', 'tb-social-widget' ); ?>
	</p>
	<?php
	}
	
	/**********************************************************/
	## Updating widget replacing old instances with new.
	/**********************************************************/
	
	public function update( $new_instance, $old_instance ) {
	
		$instance = array();
		$instance['title'] = isset( $new_instance['title'] ) ? esc_attr( $new_instance['title'] ) : '';
		$instance['tb_pinterest_borad_type'] = isset( $new_instance['tb_pinterest_borad_type'] ) ? esc_attr( $new_instance['tb_pinterest_borad_type'] ) : '';
		
		$instance['tb_pinterest_url'] = isset( $new_instance['tb_pinterest_url'] ) ? esc_attr( $new_instance['tb_pinterest_url'] ) : '';
		$instance['tb_pinterest_board_image_size'] = isset( $new_instance['tb_pinterest_board_image_size'] ) ? esc_attr( $new_instance['tb_pinterest_board_image_size'] ) : '';
		
		$instance['tb_pinterest_board_width'] = isset( $new_instance['tb_pinterest_board_width'] ) ? esc_attr( $new_instance['tb_pinterest_board_width'] ) : '';
		
		$instance['tb_pinterest_board_height'] = isset( $new_instance['tb_pinterest_board_height'] ) ? esc_attr( $new_instance['tb_pinterest_board_height'] ) : '';
		
		return $instance;
	}
	
}
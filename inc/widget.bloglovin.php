<?php 
/*
Bloglovin Button widget class
*/

class TB_Bloglovin_Button_Widget extends WP_Widget{
	
	public function __construct(){
		parent::__construct('tb_bloglovin_button', /* Unique widget ID */
			esc_html__('Buffer BlogLovin Button', 'tb-social-widget'), /* Widget title display in widget area. */
			array( 'description' => esc_html__( 'Display bloglovin button widget.', 'tb-social-widget' ), ) 
			/* Widget description */
		);
	}
	
	/************************************************************/
	## linkedin script code 
	/*************************************************************/
	
	public function tb_bloglovin_code(){
		echo '<script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s);js.id = id;js.src = "https://widget.bloglovin.com/assets/widget/loader.js";fjs.parentNode.insertBefore(js, fjs);}(document, "script", "bloglovin-sdk"))</script>';
	}
	
	/**********************************************/
	## Creating widget front-end
	## This is where the action happens 
	/*********************************************/
	
	public function widget($args, $instance){
		add_action( 'wp_footer', array($this,'tb_bloglovin_code') ); 
		$title                 = isset($instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$tb_bloglovin_url      = $instance['tb_bloglovin_url'] ? $instance['tb_bloglovin_url'] : '';
		$tb_bloglovin_btn_style = $instance['tb_bloglovin_btn_style'] ? $instance['tb_bloglovin_btn_style'] : '1';
		
		echo $args['before_widget']; /* before and after widget arguments are defined by themes */
		if($title != '')
		echo $args['before_title'] . $title . $args['after_title'];
		
		/* This is where you run the code and display the output */
	
		if($tb_bloglovin_url != ''){
			
			switch ($tb_bloglovin_btn_style) {
				case '1':
					$counter = 'true';
					$button = 'button';
				break;
				case '2':
					$counter = 'false';
					$button = 'button';
				break;
			
			}
			
			
			echo '<a data-blsdk-counter="'.$counter.'" data-blsdk-type="'.$button.'" target="_blank" href="'.$tb_bloglovin_url.'" class="blsdk-follow">Follow</a>';
			
		}
		echo $args['after_widget'];
	}
	
	/****************************************/
	## Widget Backend 
	/****************************************/
	
	public function form( $instance ) {
		
		$title  = isset( $instance[ 'title' ] ) ? esc_attr($instance[ 'title' ]) : '';
	
		$tb_bloglovin_url       = isset( $instance[ 'tb_bloglovin_url' ] ) ? esc_attr($instance[ 'tb_bloglovin_url' ]) : '';
		$tb_bloglovin_btn_style = isset($instance[ 'tb_bloglovin_btn_style' ]) ? esc_attr($instance[ 'tb_bloglovin_btn_style']) : '1';
		
		/* Widget admin form */
	?>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title') ); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_bloglovin_url') ); ?>"><?php esc_html_e( 'BlogLovin URL', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_bloglovin_url' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_bloglovin_url' )); ?>" type="text" value="<?php echo $tb_bloglovin_url; ?>" />
	</p>
	
	<p>
		<?php 
			$image_count   = TB_SW__PLUGIN_URL.'/assets/images/button_with_count.png';
			$image_nocount = TB_SW__PLUGIN_URL.'/assets/images/button_no_count.png';
			$image_full    = TB_SW__PLUGIN_URL.'/assets/images/bloglovin-button-full.png';
		?>
		<h4><?php _e('Button style:', 'tb-social-widget'); ?></h4>

		<input type="radio" id="<?php echo ($this->get_field_id( 'tb_bloglovin_btn_style' ) . '-1') ?>" name="<?php echo ($this->get_field_name( 'tb_bloglovin_btn_style' )) ?>" value="1" <?php checked( $tb_bloglovin_btn_style == 1, true) ?>>
		<label for="<?php echo ($this->get_field_id( 'tb_bloglovin_btn_style' ) . '-1' ) ?>">
			<img src="<?php echo $image_count;?>" style="position:relative;top:5px;" />
		</label>
		<br /><br />
		<input type="radio" id="<?php echo ($this->get_field_id( 'tb_bloglovin_btn_style' ) . '-2') ?>" name="<?php echo ($this->get_field_name( 'tb_bloglovin_btn_style' )) ?>" value="2" <?php checked( $tb_bloglovin_btn_style == 2, true) ?>>
			<label for="<?php echo ($this->get_field_id( 'tb_bloglovin_btn_style' ) . '-2' ) ?>">
				<img src="<?php echo $image_nocount;?>" style="position:relative;top:5px;" />
			</label>
		
	</p>
	<?php
	}
	
	/**********************************************************/
	## Updating widget replacing old instances with new.
	/**********************************************************/
	
	public function update( $new_instance, $old_instance ) {
	
		$instance = array();
		$instance['title'] = isset( $new_instance['title'] ) ? esc_attr( $new_instance['title'] ) : '';
		$instance['tb_bloglovin_url'] = isset( $new_instance['tb_bloglovin_url'] ) ? esc_attr( $new_instance['tb_bloglovin_url'] ) : '';
		$instance['tb_bloglovin_btn_style'] = isset( $new_instance['tb_bloglovin_btn_style'] ) ? esc_attr( $new_instance['tb_bloglovin_btn_style'] ) : '';
		
		
		return $instance;
	}
	
}
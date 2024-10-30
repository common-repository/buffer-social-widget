<?php 
/*
Linkedin Follow Button widget class
*/

class TB_Linkedin_Follow_Button_Widget extends WP_Widget{
	
	public function __construct(){
		parent::__construct('tb_linkedin_follow_button', /* Unique widget ID */
			esc_html__('Buffer Linkedin Follow Button', 'tb-social-widget'), /* Widget title display in widget area. */
			array( 'description' => esc_html__( 'Display linkedin follow button.', 'tb-social-widget' ), ) 
			/* Widget description */
		);
	}
	
	/************************************************************/
	## linkedin script code 
	/*************************************************************/
	
	public function tb_linkedin_code(){
		
		echo '<script defer src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>';
	}
	
	/**********************************************/
	## Creating widget front-end
	## This is where the action happens 
	/*********************************************/
	
	public function widget($args, $instance){
		
		$title                   = isset($instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$tb_linkedin_company_id  = $instance['tb_linkedin_company_id'] ? $instance['tb_linkedin_company_id'] : '';
		$tb_linkedin_counter     = $instance['tb_linkedin_counter'] ? $instance['tb_linkedin_counter'] : 'top';
		
		echo $args['before_widget']; /* before and after widget arguments are defined by themes */
		if($title != '')
		echo $args['before_title'] . $title . $args['after_title'];
		
		/* This is where you run the code and display the output */
		
		if($tb_linkedin_company_id != ''){
			add_action( 'wp_footer', array($this,'tb_linkedin_code') ); 
			echo '<script type="IN/FollowCompany" data-id="'.$tb_linkedin_company_id.'" data-counter="'.$tb_linkedin_counter.'"></script>';
		}
		echo $args['after_widget'];
	}
	
	/****************************************/
	## Widget Backend 
	/****************************************/
	
	public function form( $instance ) {
		
		$title  = isset( $instance[ 'title' ] ) ? esc_attr($instance[ 'title' ]) : '';
		$tb_linkedin_company_id  = isset( $instance[ 'tb_linkedin_company_id' ] ) ? esc_attr($instance[ 'tb_linkedin_company_id' ]) : '';
		$tb_linkedin_counter  = isset( $instance[ 'tb_linkedin_counter' ] ) ? esc_attr($instance[ 'tb_linkedin_counter' ]) : '';
		
		/* Widget admin form */
	?>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title') ); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_linkedin_company_id') ); ?>"><?php esc_html_e( 'Company Id', 'tb-social-widget' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_linkedin_company_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_linkedin_company_id' )); ?>" type="text" value="<?php echo $tb_linkedin_company_id; ?>" />
		<br/>
		<a href="https://wordpress.org/plugins/buffer-social-widget/#faq" target="_blank">How to get LinkedIn company id?<a>
	</p>
	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'tb_linkedin_counter') ); ?>"><?php esc_html_e( 'Counter Position', 'tb-social-widget' ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_linkedin_counter' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_linkedin_counter' )); ?>">
		<option value="top" <?php echo $tb_linkedin_counter == 'top' ? 'selected': ''; ?>><?php esc_html_e( 'Top', 'tb-social-widget' ); ?></option>
		<option value="right" <?php echo $tb_linkedin_counter == 'right' ? 'selected': ''; ?>><?php esc_html_e( 'Right', 'tb-social-widget' ); ?></option>
		
		</select>
	</p>
	<?php
	}
	
	/**********************************************************/
	## Updating widget replacing old instances with new.
	/**********************************************************/
	
	public function update( $new_instance, $old_instance ) {
	
		$instance = array();
		$instance['title'] = isset( $new_instance['title'] ) ? esc_attr( $new_instance['title'] ) : '';
		
		$instance['tb_linkedin_company_id'] = isset( $new_instance['tb_linkedin_company_id'] ) ? esc_attr( $new_instance['tb_linkedin_company_id'] ) : '';
		
		$instance['tb_linkedin_counter'] = isset( $new_instance['tb_linkedin_counter'] ) ? esc_attr( $new_instance['tb_linkedin_counter'] ) : '';
		
		return $instance;
	}
	
}
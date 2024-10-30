<?php 
/*
## instagram gallery plugin widget
*/
class TB_Instagram_Gallery_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct('tb_instagram_gallery', /* Unique widget ID */
			esc_html__('Buffer Instagram Gallery', 'tb-social-widget'), /* Widget title display in widget area. */
			array( 'description' => esc_html__( 'Display Instagram Gallery.', 'tb-social-widget' ), ) 
			/* Widget description */
		);
	}
	
	public function widget( $args, $instance ) {

		$title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$username = isset( $instance['tb_instagram_username'] ) ? esc_attr($instance['tb_instagram_username']) : '';
		$limit    = isset( $instance['tb_instagram_number'] ) ? esc_attr($instance['tb_instagram_number']) : '8' ;
		$target   = isset( $instance['tb_instagram_target'] ) ? esc_attr($instance['tb_instagram_target']) : '_blank';
		$link     = isset( $instance['tb_instagram_link'] ) ? esc_attr($instance['tb_instagram_link']) : '';

		echo $args['before_widget']; /* before and after widget arguments are defined by themes */
		if(!empty($title))
		echo $args['before_title'] . $title . $args['after_title'];
		/* This is where you run the code and display the output */
		
		if ( '' !== $username ) {
		
			//print_r($this->scrape_instagram( $username, $limit ));
			$media_array = $this->scrape_instagram( $username );
			//print_r($media_array);
			if ( is_wp_error( $media_array ) ) {

				echo '<p class="text-center">'. $media_array->get_error_message(). '</p>';

			} else {

				// filter for images only?
				//if ( $images_only = apply_filters( 'wrt_images_only', FALSE ) )
				//$media_array = array_filter( $media_array, array( $this, 'images_only' ) );

				// filter for images only?
				if ( $images_only = apply_filters( 'wrt_images_only', false ) ) {
					$media_array = array_filter( $media_array, array( $this, 'images_only' ) );
				}
				// slice list down to required limit.
				$media_array = array_slice( $media_array, 0, $limit );
				// filters for custom classes
			
				echo '<ul class="instagram-pics">';
				foreach ( $media_array as $item ){
					
					echo '<li><a href="'. esc_url( $item['link'] ) .'" target="'. esc_attr( $target ) .'">
					<img src="'. esc_url( $item['thumbnail'] ) .'"  alt="'. esc_attr( $item['description'] ) .'" title="'. esc_attr( $item['description'] ).'"/>
					</a>
					</li>';
					
				} //endforeach;
				echo '</ul>';
				
			}
		}
		

		echo $args['after_widget'];
	}

	public function form( $instance ) {
	
		$title = isset($instance['title']) ? esc_attr( $instance['title'] ) : '';
		$username = isset($instance['tb_instagram_username']) ? esc_attr( $instance['tb_instagram_username'] ): '';
		$number = isset($instance['tb_instagram_number']) ? absint( $instance['tb_instagram_number'] ) : '9';
		$target = isset($instance['tb_instagram_target']) ? esc_attr( $instance['tb_instagram_target'] ) : '_blank';
		
		?>
		<p><label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title', 'tb-social-widget' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'tb_instagram_username' )); ?>"><?php esc_html_e( 'Instagram #tag', 'tb-social-widget' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_instagram_username' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_instagram_username' )); ?>" type="text" value="<?php echo $username; ?>" /></label></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'tb_instagram_number' )); ?>"><?php esc_html_e( 'Number of photos', 'tb-social-widget' ); ?>: <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_instagram_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_instagram_number' )); ?>" type="text" value="<?php echo $number; ?>" /></label></p>
		
		<p><label for="<?php echo esc_attr($this->get_field_id( 'tb_instagram_target') ); ?>"><?php esc_html_e( 'Open links in', 'tb-social-widget' ); ?>:</label>
			<select id="<?php echo esc_attr($this->get_field_id( 'tb_instagram_target') ); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_instagram_target' )); ?>" class="widefat">
				<option value="_self" <?php selected( '_self', $target ) ?>><?php esc_html_e( 'Current window (_self)', 'tb-social-widget' ); ?></option>
				<option value="_blank" <?php selected( '_blank', $target ) ?>><?php esc_html_e( 'New window (_blank)', 'tb-social-widget' ); ?></option>
			</select>
		</p>
		
		<?php

	}

	public function update( $new_instance, $old_instance ) {
	
		$instance = array();
		$instance['title'] = isset($new_instance['title']) ? esc_html($new_instance['title']) : '';
		$instance['tb_instagram_username'] = trim(strip_tags($new_instance['tb_instagram_username'])) ? esc_html($new_instance['tb_instagram_username']) : '';
		$instance['tb_instagram_number'] = isset($new_instance['tb_instagram_number']) ? esc_html($new_instance['tb_instagram_number']) : '';
		$instance['tb_instagram_target'] = isset($new_instance['tb_instagram_target']) ? esc_html($new_instance['tb_instagram_target']) : '_blank';
		$instance['tb_instagram_link'] = isset($new_instance['tb_instagram_link']) ? esc_html($new_instance['tb_instagram_link']) : '';
		
		return $instance;
	}

	
	public function scrape_instagram( $username ) {

		$username = trim( strtolower( $username ) );

		/* switch ( substr( $username, 0, 1 ) ) {
			case '#':
				$url              = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
				$transient_prefix = 'h';
				break;

			default:
				$url              = 'https://instagram.com/' . str_replace( '@', '', $username );
				$transient_prefix = 'u';
				break;
		} */
		
		$url = 'https://instagram.com/explore/tags/' . str_replace( '#', '', $username );
		$transient_prefix = 'h';

		if ( false === ( $instagram = get_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) ) ) ) {

			$remote = wp_remote_get( $url );

			if ( is_wp_error( $remote ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'tb-social-widget' ) );
			}

			if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'tb-social-widget' ) );
			}

			$shards      = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json  = explode( ';</script>', $shards[1] );
			$insta_array = json_decode( $insta_json[0], true );

			if ( ! $insta_array ) {
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'tb-social-widget' ) );
			}

			if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
			} elseif ( isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
				$images = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'tb-social-widget' ) );
			}

			if ( ! is_array( $images ) ) {
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'tb-social-widget' ) );
			}

			$instagram = array();

			foreach ( $images as $image ) {
				if ( true === $image['node']['is_video'] ) {
					$type = 'video';
				} else {
					$type = 'image';
				}

				$caption = __( 'Instagram Image', 'tb-social-widget' );
				if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
					$caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
				}

				$instagram[] = array(
					'description' => $caption,
					'link'        => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
					'time'        => $image['node']['taken_at_timestamp'],
					'comments'    => $image['node']['edge_media_to_comment']['count'],
					'likes'       => $image['node']['edge_liked_by']['count'],
					'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
					'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
					'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
					'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
					'type'        => $type,
				);
			} // End foreach().

			// do not set an empty transient - should help catch private or empty accounts.
			if ( ! empty( $instagram ) ) {
				$instagram = base64_encode( serialize( $instagram ) );
				set_transient( 'insta-a10-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
			}
		}

		if ( ! empty( $instagram ) ) {

			return unserialize( base64_decode( $instagram ) );

		} else {

			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'tb-social-widget' ) );

		}
	}

	public function images_only( $media_item ) {

		if ( $media_item['type'] == 'image' )
			return true;
		return false;
	}

}
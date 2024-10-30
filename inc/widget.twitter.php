<?php 
/*
// Twitter widget class
*/

class TB_Twitter_Timeline_Widget extends wP_Widget{
	
	public function __construct(){
		
		parent::__construct(
			'tb_twitter_feeds', // Base ID
			esc_html__('Buffer Twitter Widget', 'tb-social-widget'), // Name
			array( 'description' => esc_html__( 'Display your latest tweets from twitter.com', 'tb-social-widget' ), ) // Args
		);
	}
	
	public function tb_twitter_widget_js(){
		echo '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
	}
	/*
	# widget frontend 
	*/
	
	function widget($args, $instance) {
		
		add_action( 'wp_footer', array($this,'tb_twitter_widget_js') );  
		
		$title   = isset($instance['title']) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$tb_twitter_screenName    = isset($instance['tb_twitter_screenName']) ? esc_attr($instance['tb_twitter_screenName']) : '';
		$tb_twitter_sourceType    = isset($instance['tb_twitter_sourceType']) ? esc_attr($instance['tb_twitter_sourceType']) : 'timeline';
		$tb_twitter_timelineType  = isset($instance['tb_twitter_timelineType']) ? esc_attr($instance['tb_twitter_timelineType']) : 'profile';
		
		$tb_twitter_tweetLimit   = isset($instance['tb_twitter_tweetLimit']) ? esc_attr($instance['tb_twitter_tweetLimit']) : '5';
		$tb_twitter_showreplies  = isset($instance['tb_twitter_showreplies']) ? esc_attr($instance['tb_twitter_showreplies']) : '';
		$tb_twitter_theme        = isset($instance['tb_twitter_theme']) ? esc_attr($instance['tb_twitter_theme']) : 'light';
		$tb_twitter_width        = isset($instance['tb_twitter_width']) ? esc_attr($instance['tb_twitter_width']) : '';
		$tb_twitter_height       = isset($instance['tb_twitter_height']) ? esc_attr($instance['tb_twitter_height']) : '';
		
		$tb_twitter_noheader    = isset($instance['tb_twitter_noheader']) ? esc_attr($instance['tb_twitter_noheader']) : '';
		$tb_twitter_nofooter    = isset($instance['tb_twitter_nofooter']) ? esc_attr($instance['tb_twitter_nofooter']) : '';
		$tb_twitter_noborders   = isset($instance['tb_twitter_noborders']) ? esc_attr($instance['tb_twitter_noborders']) : '';
		$tb_twitter_transparent = isset($instance['tb_twitter_transparent']) ? esc_attr($instance['tb_twitter_transparent']) : '';
		$tb_twitter_noscrollbar = isset($instance['tb_twitter_noscrollbar']) ? esc_attr($instance['tb_twitter_noscrollbar']) : '';
	
		// output the widget
		echo $args['before_widget'];
		if($title != '')
		echo $args['before_title'] . $title . $args['after_title'];
		
		
		 
		if($tb_twitter_screenName != ''){
			
			if($tb_twitter_timelineType == 'lists'){
				$tb_twitter_list_slug = isset($instance['tb_twitter_list_slug']) ? esc_attr($instance['tb_twitter_list_slug']) : '';
				$twitterLink = 'https://twitter.com/'.$tb_twitter_screenName.'/lists/'.$tb_twitter_list_slug;
			}
			elseif($tb_twitter_timelineType == 'collections'){
				$tb_twitter_collection_id = isset($instance['tb_twitter_collection_id']) ? esc_attr($instance['tb_twitter_collection_id']) : '';
				$twitterLink = 'https://twitter.com/'.$tb_twitter_screenName.'/timelines/'.$tb_twitter_collection_id;
			}
			elseif($tb_twitter_timelineType == 'likes'){
				$twitterLink = 'https://twitter.com/'.$tb_twitter_screenName.'/likes';
				$footer_text = 'Tweets liked by @'.$tb_twitter_screenName;
			}
			else{
				$twitterLink = 'https://twitter.com/'.$tb_twitter_screenName;
				$footer_text = 'Tweets by @'.$tb_twitter_screenName;
			}
		
			echo '<a class="twitter-'.$tb_twitter_sourceType.'" href="'.$twitterLink.'"';
			
			if($tb_twitter_theme != '') 
				echo ' data-theme="'.$tb_twitter_theme.'" '; 
			
			if($tb_twitter_showreplies == 1) 
				echo ' data-show-replies="true" ';
			
			if($tb_twitter_width != '') 
				echo ' data-width="'.$tb_twitter_width.'" '; 
				
			if($tb_twitter_height != '') 
				echo ' data-height="'.$tb_twitter_height.'"'; 
			
			if($tb_twitter_tweetLimit != '') 
				echo ' data-tweet-limit="'.$tb_twitter_tweetLimit.'"';
			
			if($tb_twitter_noheader == 1 || $tb_twitter_nofooter == 1 || $tb_twitter_noborders == 1 || $tb_twitter_transparent == 1 || $tb_twitter_noscrollbar == 1) {
				$chorme = '';
				if($tb_twitter_noheader == 1)
				  $chorme .= 'noheader';
				if($tb_twitter_nofooter == 1)
				  $chorme .= 'nofooter';
				if($tb_twitter_noborders == 1)
				  $chorme .= 'noborders';
				if($tb_twitter_transparent == 1)
				  $chorme .= 'transparent';
				if($tb_twitter_noscrollbar == 1)
				  $chorme .= 'noscrollbar';
				
			  echo ' data-chrome="'.$chorme.'"';
			}
		  
			echo '>'.$footer_text.'</a>';
		}
		
		echo $args['after_widget'];
	}
	
	/*
	## widget form 
	*/
	public function form($instance) {
		
		$title   = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$tb_twitter_screenName    = isset($instance['tb_twitter_screenName']) ? esc_attr($instance['tb_twitter_screenName']) : '';
		$tb_twitter_sourceType    = isset($instance['tb_twitter_sourceType']) ? esc_attr($instance['tb_twitter_sourceType']) : '';
		$tb_twitter_timelineType  = isset($instance['tb_twitter_timelineType']) ? esc_attr($instance['tb_twitter_timelineType']) : '';
		
		$tb_twitter_tweetLimit   = isset($instance['tb_twitter_tweetLimit']) ? esc_attr($instance['tb_twitter_tweetLimit']) : '5';
		$tb_twitter_showreplies  = isset($instance['tb_twitter_showreplies']) ? esc_attr($instance['tb_twitter_showreplies']) : '';
		$tb_twitter_theme        = isset($instance['tb_twitter_theme']) ? esc_attr($instance['tb_twitter_theme']) : '';
		$tb_twitter_width        = isset($instance['tb_twitter_width']) ? esc_attr($instance['tb_twitter_width']) : '';
		$tb_twitter_height       = isset($instance['tb_twitter_height']) ? esc_attr($instance['tb_twitter_height']) : '';
		
		$tb_twitter_list_slug = isset($instance['tb_twitter_list_slug']) ? esc_attr($instance['tb_twitter_list_slug']) : '';
		$tb_twitter_collection_id = isset($instance['tb_twitter_collection_id']) ? esc_attr($instance['tb_twitter_collection_id']) : '';
		$tb_twitter_noheader    = isset($instance['tb_twitter_noheader']) ? esc_attr($instance['tb_twitter_noheader']) : '';
		$tb_twitter_nofooter    = isset($instance['tb_twitter_nofooter']) ? esc_attr($instance['tb_twitter_nofooter']) : '';
		$tb_twitter_noborders   = isset($instance['tb_twitter_noborders']) ? esc_attr($instance['tb_twitter_noborders']) : '';
		$tb_twitter_transparent = isset($instance['tb_twitter_transparent']) ? esc_attr($instance['tb_twitter_transparent']) : '';
		$tb_twitter_noscrollbar = isset($instance['tb_twitter_noscrollbar']) ? esc_attr($instance['tb_twitter_noscrollbar']) : '';
		
	?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Widget Title', 'tb-social-widget' ); ?> </label>
			<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo $title; ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_screenName')); ?>" style="line-height:35px;display:block;">
			<?php esc_html_e( 'Twitter Screen Name', 'tb-social-widget' ); ?>: @</label>
			<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('tb_twitter_screenName')); ?>" name="<?php echo esc_attr($this->get_field_name('tb_twitter_screenName')); ?>" value="<?php echo $tb_twitter_screenName; ?>" />
			
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_sourceType')); ?>">
			<?php esc_html_e( 'Display Styles', 'tb-social-widget' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id('tb_twitter_sourceType')); ?>" name="<?php echo esc_attr($this->get_field_name('tb_twitter_sourceType')); ?>">
				<option value="timeline" <?php echo isset($tb_twitter_sourceType) && $tb_twitter_sourceType == 'timeline' ? 'selected' : '' ; ?>><?php esc_html_e('Linear', 'tb-social-widget') ?></option>
				<option value="grid" <?php echo isset($tb_twitter_sourceType) && $tb_twitter_sourceType == 'grid' ? 'selected' : '' ; ?>><?php esc_html_e('Grid', 'tb-social-widget') ?></option>
				
			</select>
			
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_timelineType')); ?>">
			<?php esc_html_e( 'Timeline Types', 'tb-social-widget' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id('tb_twitter_timelineType')); ?>" name="<?php echo esc_attr($this->get_field_name('tb_twitter_timelineType')); ?>">
				
				<option value="profile" <?php echo isset($tb_twitter_timelineType) && $tb_twitter_timelineType == 'profile' ? 'selected' : '' ; ?>><?php esc_html_e('Profile', 'tb-social-widget') ?></option>
				<option value="lists" <?php echo isset($tb_twitter_timelineType) && $tb_twitter_timelineType == 'lists' ? 'selected' : '' ; ?>><?php esc_html_e('Lists', 'tb-social-widget') ?></option>
				<option value="collections" <?php echo isset($tb_twitter_timelineType) && $tb_twitter_timelineType == 'collections' ? 'selected' : '' ; ?>><?php esc_html_e('Collections', 'tb-social-widget') ?></option>
				<option value="likes" <?php echo isset($tb_twitter_timelineType) && $tb_twitter_timelineType == 'likes' ? 'selected' : '' ; ?>><?php esc_html_e('Likes', 'tb-social-widget') ?></option>
				
			</select>
			
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_tweetLimit')); ?>"><?php esc_html_e( 'Tweet Limit', 'tb-social-widget' ); ?> <input type="number" id="<?php echo esc_attr($this->get_field_id('tb_twitter_tweetLimit')); ?>" size="2" name="<?php echo esc_attr($this->get_field_name('tb_twitter_tweetLimit')); ?>" value="<?php echo $tb_twitter_tweetLimit; ?>"  min="1" max="20" /></label>
		</p>
		<p>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('tb_twitter_showreplies')); ?>" value="1" name="<?php echo esc_attr($this->get_field_name('tb_twitter_showreplies')); ?>"<?php if($tb_twitter_showreplies){ ?> checked="checked"<?php } ?>> 
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_showreplies')); ?>"><?php esc_html_e( 'Show Replies?', 'tb-social-widget' ); ?></label>
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_theme')); ?>">
			<?php esc_html_e( 'Timeline Theme Style', 'tb-social-widget' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id('tb_twitter_theme')); ?>" name="<?php echo esc_attr($this->get_field_name('tb_twitter_theme')); ?>">
				<option value="light" <?php echo isset($tb_twitter_theme) && $tb_twitter_theme == 'light' ? 'selected' : '' ; ?>><?php esc_html_e('Light', 'tb-social-widget') ?></option>
				<option value="dark" <?php echo isset($tb_twitter_theme) && $tb_twitter_theme == 'dark' ? 'selected' : '' ; ?>><?php esc_html_e('Dark', 'tb-social-widget') ?></option>
			</select>
			
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'tb_twitter_width' )); ?>"><?php esc_html_e( 'Width', 'tb-social-widget' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_twitter_width' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_twitter_width' )); ?>" type="text" value="<?php echo $tb_twitter_width; ?>" /><?php esc_html_e( 'Pixels', 'tb-social-widget' ); ?>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'tb_twitter_height' )); ?>"><?php esc_html_e( 'Height', 'tb-social-widget' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_twitter_height' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_twitter_height' )); ?>" type="text" value="<?php echo $tb_twitter_height; ?>" /><?php esc_html_e( 'Pixels', 'tb-social-widget' ); ?>
		</p>
		
		
		<p>
			<strong>
			<?php esc_html_e( 'Timeline Elements', 'tb-social-widget' ); ?>
			</Strong>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'tb_twitter_list_slug' )); ?>"><?php esc_html_e( 'Twitter List Slug', 'tb-social-widget' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_twitter_list_slug' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_twitter_list_slug' )); ?>" type="text" value="<?php echo $tb_twitter_list_slug; ?>" />
			<br/><?php esc_html_e( 'Valid for twitter lists style', 'tb-social-widget' ); ?><br/>
			<a href="<?php esc_url('https://developer.twitter.com/en/docs/twitter-for-websites/timelines/guides/list-timeline')?>" target="_blank"><?php esc_html_e( 'Twitter List Guide', 'tb-social-widget' ); ?></a>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'tb_twitter_collection_id' )); ?>"><?php esc_html_e( 'Collection Id', 'tb-social-widget' ); ?></label> 
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'tb_twitter_collection_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'tb_twitter_collection_id' )); ?>" type="text" value="<?php echo $tb_twitter_collection_id; ?>" />
			<br/><?php esc_html_e( 'Valid for twitter collection style', 'tb-social-widget' ); ?><br/>
			<a href="<?php esc_url('https://developer.twitter.com/en/docs/twitter-for-websites/timelines/guides/collection')?>" target="_blank"><?php esc_html_e( 'Twitter Collections Guide', 'tb-social-widget' ); ?></a>
		</p>
		<p>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('tb_twitter_noheader')); ?>" value="1" name="<?php echo esc_attr($this->get_field_name('tb_twitter_noheader')); ?>"<?php if($tb_twitter_noheader){ ?> checked="checked"<?php } ?>> 
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_noheader')); ?>"><?php esc_html_e( 'No Header', 'tb-social-widget' ); ?></label>
		</p>
		<p>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('tb_twitter_nofooter')); ?>" value="1" name="<?php echo esc_attr($this->get_field_name('tb_twitter_nofooter')); ?>"<?php if($tb_twitter_nofooter){ ?> checked="checked"<?php } ?>> 
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_nofooter')); ?>"><?php esc_html_e( 'No Footer', 'tb-social-widget' ); ?></label>
		</p>
		<p>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('tb_twitter_noborders')); ?>" value="1" name="<?php echo esc_attr($this->get_field_name('tb_twitter_noborders')); ?>"<?php if($tb_twitter_noborders){ ?> checked="checked"<?php } ?>> 
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_noborders')); ?>"><?php esc_html_e( 'No Border', 'tb-social-widget' ); ?></label>
		</p>
		<p>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('tb_twitter_transparent')); ?>" value="1" name="<?php echo esc_attr($this->get_field_name('tb_twitter_transparent')); ?>"<?php if($tb_twitter_transparent){ ?> checked="checked"<?php } ?>> 
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_transparent')); ?>"><?php esc_html_e( 'Transparent', 'tb-social-widget' ); ?></label>
		</p>
		<p>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('tb_twitter_noscrollbar')); ?>" value="1" name="<?php echo esc_attr($this->get_field_name('tb_twitter_noscrollbar')); ?>"<?php if($tb_twitter_noscrollbar){ ?> checked="checked"<?php } ?>> 
			<label for="<?php echo esc_attr($this->get_field_id('tb_twitter_noscrollbar')); ?>"><?php esc_html_e( 'No Scrollbar', 'tb-social-widget' ); ?></label>
		</p>
<?php
	}
	
	public function update($new_instance, $old_instance) {
	
		// processes widget options to be saved
		$instance = array();
		$instance['title']   = isset($new_instance['title']) ? esc_html($new_instance['title']) : '';
		$instance['tb_twitter_screenName']    = isset($new_instance['tb_twitter_screenName']) ? esc_html($new_instance['tb_twitter_screenName']) : '';
		$instance['tb_twitter_sourceType']    = isset($new_instance['tb_twitter_sourceType']) ? esc_html($new_instance['tb_twitter_sourceType']) : '';
		$instance['tb_twitter_timelineType']  = isset($new_instance['tb_twitter_timelineType']) ? esc_attr($new_instance['tb_twitter_timelineType']) : '';
		
		$instance['tb_twitter_list_slug'] = isset($new_instance['tb_twitter_list_slug']) ? esc_attr($new_instance['tb_twitter_list_slug']) : '';
		$instance['tb_twitter_collection_id'] = isset($new_instance['tb_twitter_collection_id']) ? esc_attr($new_instance['tb_twitter_collection_id']) : '';
		
		$instance['tb_twitter_tweetLimit']   = isset($new_instance['tb_twitter_tweetLimit']) ? esc_attr($new_instance['tb_twitter_tweetLimit']) : '5';
		$instance['tb_twitter_showreplies']  = isset($new_instance['tb_twitter_showreplies']) ? esc_attr($new_instance['tb_twitter_showreplies']) : '';
		$instance['tb_twitter_theme']        = isset($new_instance['tb_twitter_theme']) ? esc_attr($new_instance['tb_twitter_theme']) : '';
		$instance['tb_twitter_width']        = isset($new_instance['tb_twitter_width']) ? esc_attr($new_instance['tb_twitter_width']) : '';
		$instance['tb_twitter_height']       = isset($new_instance['tb_twitter_height']) ? esc_attr($new_instance['tb_twitter_height']) : '';
		
		$instance['tb_twitter_noheader']    = isset($new_instance['tb_twitter_noheader']) ? esc_attr($new_instance['tb_twitter_noheader']) : '';
		$instance['tb_twitter_nofooter']    = isset($new_instance['tb_twitter_nofooter']) ? esc_attr($new_instance['tb_twitter_nofooter']) : '';
		$instance['tb_twitter_noborders']   = isset($new_instance['tb_twitter_noborders']) ? esc_attr($new_instance['tb_twitter_noborders']) : '';
		$instance['tb_twitter_transparent'] = isset($new_instance['tb_twitter_transparent']) ? esc_attr($new_instance['tb_twitter_transparent']) : '';
		$instance['tb_twitter_noscrollbar'] = isset($new_instance['tb_twitter_noscrollbar']) ? esc_attr($new_instance['tb_twitter_noscrollbar']) : '';
		
		return $instance;
	}
	
}
<div class="wrap wpsc">
<?php $wpsc_link = ($wpsc_pro?'':' Exclude feature is a premium feature. <a href="'.$wpsc_premium_link.'" target="_blank" class="premium">Go Premium</a>'); ?>
<h2>WP Secure Content <?php echo '('.$wpsc_data['Version'].($wpsc_pro?') Pro':')'); ?> - Settings</h2>

<?php 
	if(!empty($_POST) && isset($_POST['wpsc_exclude'])){
		update_option('wpsc_arr', $_POST['wpsc_exclude']);
?>
		<div class="notice notice-success is-dismissible">
			<p><?php _e( 'Successfully updated.'.$wpsc_link, 'wpsc-text-domain' ); ?></p>
		</div>
<?php	
	}
	$wpsc_arr = get_option('wpsc_arr');
	//pree($wpsc_arr);
	$wpsc_arr = (is_array($wpsc_arr)?$wpsc_arr:array());
	$items = array();
	$args = array(
		'posts_per_page'   => -1,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'title',
		'order'            => 'ASC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'any',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$posts_array = get_posts( $args );
	if(!empty($posts_array)){
		foreach($posts_array as $post){
			$items[$post->post_type][$post->ID] = array('guid'=>$post->guid, 'post_title'=>$post->post_title);
		}
	}
	
	//pree($items);
	if(!empty($items)){
?>
<form action="" method="post">		
<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'wp-sc' ); ?>" /></p>  
<?php		
		foreach($items as $type=>$list){
?>
		<h4>Check/uncheck to exclude <i><?php echo strtoupper($type); ?></i></h4>	
		<ul>
<?php     
		foreach($list as $id=>$item){       
?>
		<li><input type="checkbox" name="wpsc_exclude[]" value="<?php echo $id; ?>" <?php echo (in_array($id, $wpsc_arr)?'checked="checked"':''); ?> /><?php echo $item['post_title']; ?> - <a href="post.php?post=<?php echo $id; ?>&action=edit">Edit</a>&nbsp;|&nbsp;<a href="<?php echo $item['guid']; ?>" target="_blank">View</a></li>
<?php			
		}
?>
		</ul>
<?php			
		}
?>     
<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'wp-sc' ); ?>" /></p>   
</form>
<?php		
	}
?>
</div>	
<style type="text/css">
.update-nag, #wpfooter{ display:none; }
</style>
<?php 
/*
Plugin Name: WP Secure Content
Plugin URI: http://www.websitedesignwebsitedevelopment.com/wordpress/plugins/wp-sc
Description: WP Secure Content is a great plugin to secure your posts/pages and WooCommerce products content. It is simple to use and easy to understand for customization.
Version: 1.1.1
Author: Fahad Mahmood 
Author URI: http://www.androidbubbles.com
License: GPL2

This WordPress Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
This free software is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with this software. If not, see http://www.gnu.org/licenses/gpl-2.0.html.
*/ 


        
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        

	global $wpsc_premium_link, $wpsc_premium, $wpsc_pro, $wpsc_dir, $wpsc_data;
	
	$rendered = FALSE;
	
	$wpsc_premium_link = 'http://shop.androidbubbles.com/product/wp-secure-content-pro';
	

	
	$wpsc_data = get_plugin_data(__FILE__);
	
	$wpsc_dir = plugin_dir_path( __FILE__ );
	$wpsc_premium = $wpsc_dir.'pro/wpsc_extended.php';
	$wpsc_pro = file_exists($wpsc_premium);
	
	if($wpsc_pro)
	include($wpsc_premium);	
	
	include('inc/functions.php');
        
	

	add_action( 'admin_enqueue_scripts', 'register_sc_scripts' );
	add_action( 'wp_enqueue_scripts', 'register_sc_scripts' );
	

	

	
	function wpsc_backup_pro($src='pro', $dst='') { 

		$plugin_dir = plugin_dir_path( __FILE__ );
		$uploads = wp_upload_dir();
		$dst = ($dst!=''?$dst:$uploads['basedir']);
		$src = ($src=='pro'?$plugin_dir.$src:$src);
		
		$pro_check = basename($plugin_dir);

		$pro_check = $dst.'/'.$pro_check.'.dat';

		if(file_exists($pro_check)){
			if(!is_dir($plugin_dir.'pro')){
				mkdir($plugin_dir.'pro');
			}
			$files = file_get_contents($pro_check);
			$files = explode('\n', $files);
			if(!empty($files)){
				foreach($files as $file){
					
					if($file!=''){
						
						$file_src = $uploads['basedir'].'/'.$file;
						//echo $file_src.' > '.$plugin_dir.'pro/'.$file.'<br />';
						$file_trg = $plugin_dir.'pro/'.$file;
						if(!file_exists($file_trg))
						copy($file_src, $file_trg);
					}
				}//exit;
			}
		}
		
		if(is_dir($src)){
			if(!file_exists($pro_check)){
				$f = fopen($pro_check, 'w');
				fwrite($f, '');
				fclose($f);
			}	
			$dir = opendir($src); 
			@mkdir($dst); 
			while(false !== ( $file = readdir($dir)) ) { 
				if (( $file != '.' ) && ( $file != '..' )) { 
					if ( is_dir($src . '/' . $file) ) { 
						wpsc_backup_pro($src . '/' . $file, $dst . '/' . $file); 
					} 
					else { 
						$dst_file = $dst . '/' . $file;
						
						if(!file_exists($dst_file)){
							
							copy($src . '/' . $file,$dst_file); 
							$f = fopen($pro_check, 'a+');
							fwrite($f, $file.'\n');
							fclose($f);
						}
					} 
				} 
			} 
			closedir($dir); 
			
		}	
	}
		
	function wpsc_activate() {	
		
		wpsc_backup_pro();
		
	}
	register_activation_hook( __FILE__, 'wpsc_activate' );	
	
	if(is_admin()){
		add_action( 'admin_menu', 'wpsc_menu' );	
		//add_action( 'wp_ajax_sc_tax_types', 'wpsc_tax_types_callback' );
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'wpsc_plugin_links' );	
		
	}else{
		
	
		
		
	}
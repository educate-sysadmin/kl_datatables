<?php
/*
Plugin Name: KL DataTables
Plugin URI: https://github.com/educate-sysadmin/kl-datatables
Description: Enable DataTables (https://datatables.net)
Version: 0.1
Author: b.cunningham@ucl.ac.uk
Author URI: https://educate.london
License: GPL2
*/
// Ref: https://developer.wordpress.org/reference/functions/wp_register_script/
// Ref: https://developer.wordpress.org/reference/functions/wp_enqueue_script/

require_once('kl-datatables-options.php');

/* default datatables sources */
function kl_datatables_js() {
	return plugins_url( '/vendor/DataTables/'.'datatables.min.js',__FILE__ );
}
function kl_datatables_css() {
	return plugins_url( '/vendor/DataTables/'.'datatables.min.css',__FILE__ );
}

/* handle wp_enqueue_scripts with reference to settings */
function kl_datatables() {
   	global $wp;	

	// check pages to load datatables on if set
	$load = true;	
	if (get_option('kl_datatables_pages') && get_option('kl_datatables_pages') !== '') {
		$load = false;
		$url = $wp->request;
		if ($url == '') $url = $_SERVER['REQUEST_URI'];		
		// always load for kl-datatables settings page example
		if (strpos($url,'page=kl-datatables') !== false) {
			$load = true;
		} else {
    		$kl_datatables_pages = get_option('kl_datatables_pages'); 
	    	if ($kl_datatables_pages !== '') {
		    	// check for home page
		    	if ($url === '') { 
	    			if (strpos('{home}',$kl_datatables_pages) !== false) {
		    			$load = true;
	    			}
	    		} else {
					// check other urls
					$pages = explode(',',$kl_datatables_pages);
					foreach ($pages as $page) {
						if (preg_match('/'.preg_quote($page).'/',$url)) {
							$load = true; 
							break;
						}
					}
				}
			}
	    }
	}
	
	if ($load) {
		$kl_datatables_js = (get_option('kl_datatables_js') && get_option('kl_datatables_js') !== '')?get_option('kl_datatables_js'):kl_datatables_js();
		$kl_datatables_css = (get_option('kl_datatables_css') && get_option('kl_datatables_css') !== '')?get_option('kl_datatables_css'):kl_datatables_css();
		wp_register_script( 'kl-datatables-js', $kl_datatables_js , '', '', true );        
		wp_register_style( 'kl-datatables-css', $kl_datatables_css, '', '', false );  // must be false i.e. to go in head?     
		wp_enqueue_script( 'kl-datatables-js' );	
		wp_enqueue_style( 'kl-datatables-css' );

		// make settings table a datatable example
		if (strpos($url,'page=kl-datatables') !== false) {				
			wp_register_script( 'kl-datatables-js-example', plugins_url( '/js/'.'kl-datatables-example.js',__FILE__ ) , '', '', true );        
			wp_enqueue_script( 'kl-datatables-js-example' );		
		}
	}	
}

add_action( 'wp_enqueue_scripts', 'kl_datatables' );
add_action( 'admin_enqueue_scripts', 'kl_datatables' );


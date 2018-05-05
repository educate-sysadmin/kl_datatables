<?php
/*
KL DataTables settings
Author: b.cunningham@ucl.ac.uk
Author URI: https://educate.london
License: GPL2
*/

// create custom plugin settings menu
add_action('admin_menu', 'kl_datatables_create_menu');

function kl_datatables_create_menu() {
	//create options page
	add_options_page('KL DataTables', 'KL DataTables', 'manage_options', __FILE__, 'kl_datatables_plugin_settings_page' , __FILE__ );
	//call register settings function
	add_action( 'admin_init', 'register_kl_datatables_plugin_settings' );
}

function register_kl_datatables_plugin_settings() {
	//register our settings
	register_setting( 'kl-datatables-plugin-settings-group', 'kl_datatables_js' );
	register_setting( 'kl-datatables-plugin-settings-group', 'kl_datatables_css' );	
	register_setting( 'kl-datatables-plugin-settings-group', 'kl_datatables_pages' );
}

function kl_datatables_plugin_settings_page() {
?>
<div class="wrap">
<h1>KL DataTables Settings</h1>

<p>(If DataTables has loaded correctly, the settings table below should demonstrate DataTables formatting).</p>

<form method="post" action="options.php">
    <?php settings_fields( 'kl-datatables-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'kl-datatables-plugin-settings-group' ); ?>
    <table class="form-table" id="kl-datatables-example">
    	<thead>
    	<tr><th>Setting</th><th>Value</th><th>Description</th></tr>
    	</thead>
    	
    	<tbody>        
        <tr>
        <td>DataTables js source</td>
        <td>
       	<input type="text" name="kl_datatables_js" value="<?php echo esc_attr( get_option('kl_datatables_js') ); ?>"  size = "30" />
       	</td>
       	<td>       	
		<p><small>If not set, uses DataTables js file included with plugin.
		<br/>Default: <?php echo kl_datatables_js(); ?></small></p>
        </td>
        </tr>
        
        <tr>
        <td>DataTables css source</td>
        <td>
		<input type="text" name="kl_datatables_css" value="<?php echo esc_attr( get_option('kl_datatables_css') ); ?>"  size = "30" />
		</td>
		<td>
		<p><small>If not set, uses DataTables css file included with plugin.
		<br/>Default: <?php echo kl_datatables_css(); ?></small></p>        	
        </td>
        </tr>        
         
        <tr>
        <td>Pages to use DataTables</td>
        <td>
		<input type="text" name="kl_datatables_pages" value="<?php echo esc_attr( get_option('kl_datatables_pages') ); ?>" size = "30" />
		</td>
		<td>
		<p><small>If set, only loads DataTables on designated pages (frontend or admin), to optimise performance.
		Comma-delimited, matches loosely as regexp. Use {home} for site home page.
		</small></p>
        </td>
        </tr>
        
        </tbody>
                        
    </table>
    
    <?php submit_button(); ?>    
    
    <h2>Usage</h2>
    <p>Call .DataTable() from JavaScript as required, at end of page (e.g. using Scripts n Styles plugin, or admin_enqueue_scripts):</br/>
    <pre>
	jQuery(document).ready( function () {
    	jQuery('.my_datatable').DataTable({ /* options if required */ } );
	} );    
    </pre>
    <p>
        
</form>
</div>
<?php } ?>
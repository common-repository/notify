<?php 

add_filter( 'plugin_action_links_notify/notify.php', 'notify_plugin_manage_link', 10, 4 );

function notify_plugin_manage_link( $actions, $plugin_file, $plugin_data, $context ) {
	
	// add a 'Configure' link to the front of the actions list for this plugin
	return array_merge( array( 'configure' => '<a href="' . admin_url( 'options-general.php?page=notify' ) . '">' . __( 'Settings' ) . '</a>' ), 
                            $actions );		
}

add_filter('show_admin_bar', '__return_false');  
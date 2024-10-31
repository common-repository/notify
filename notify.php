<?php
/*
Plugin Name: Notify
Plugin URI: http://wordpress.org/extend/plugins/notify/
Description: Slick bubble notification to your homepage
Version: 1.2
Author: Ondřej Dadok
Author URI: http://www.ondrejdadok.cz/notify/
License: GPL2
*/

include "lib/functions.php";

$_notify_PLUGIN_URL = plugins_url('', __FILE__);
$_notify_TURN_ON = 0;

if(get_option('notify_fadein') == ""){update_option('notify_fadein', '1');}
if(get_option('notify_fadeout') == ""){update_option('notify_fadeout', '4');}
if(get_option('notify_turnon') == ""){update_option('notify_turno', '0');}

if(get_option('notify_subject') == ""){update_option('notify_subject', 'Subject of message');}
if(get_option('notify_message') == ""){update_option('notify_message', 'This is a sample of Notify message');}



function notify_scripts_method() {
    wp_enqueue_script( 'jquery' );    
    wp_enqueue_script( 'jquery-ui' );    
}    
 
add_action('init', 'notify_scripts_method');

add_action('wp_head', 'notify_add_head');
add_action('wp_print_scripts', 'notify_add_head');

function notify_add_head() {
	
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script('jquery-ui-core', false, array('jquery'), false, false);
	wp_enqueue_script('jquery-ui-slider', false, array('jquery'), false, false);
	        
	wp_register_style( 'notify_style_bubble', plugins_url('bubble.css', __FILE__) );
	wp_enqueue_style( 'notify_style_bubble' );
	
	wp_enqueue_script( 'jquery-effects' );
	
		
	wp_register_style( 'notify_jqueryui_style', plugins_url('js/jquery-ui.css', __FILE__));
	wp_enqueue_style( 'notify_jqueryui_style' );
	
	wp_register_style( 'notify_style', plugins_url('style.css', __FILE__) );
	wp_enqueue_style( 'notify_style' );
	
	wp_enqueue_script('jquery-flip', plugins_url('js/jquery.flip.min.js', __FILE__), array('jquery'));
	
	wp_register_script( 'notify_utils', plugins_url('js/utils.js', __FILE__), array('jquery') );
	wp_enqueue_script( 'notify_utils' );
	
	wp_register_script( 'rotate_box', plugins_url('js/rotate-box.js', __FILE__), array('jquery') );
	wp_enqueue_script( 'rotate_box' );
	
	if(!empty($_POST['notify_fadein'])){
		$fadein=$_POST['notify_fadein'];
		$fadeout=$_POST['notify_fadeout'];
	}else{
		$fadein=get_option('notify_fadein');
		$fadeout=get_option('notify_fadeout');
	}
	
	echo "<script> var notify_fadein = ".$fadein."; var notify_fadeout = ".$fadeout."; </script>";
	wp_enqueue_script('notify_custom', plugins_url('js/notify.custom.js', __FILE__), array('jquery'));
	
}


add_action('wp_footer', 'notify_add_wpfooter');

function notify_add_wpfooter() {
	if((is_admin()) || (get_option('notify_turnon') == "1" && is_home())){
	?>
	  <section class="bubblecontainer">
	    <div id="cube" class="show-back">
	      <figure class="back"></figure>
	      <figure class="front">
	      <em>&nbsp;</em>
	      		<p>
	      		<em>&nbsp;</em>
	      		<strong><?php echo get_option('notify_subject'); ?></strong>
	      		<?php echo get_option('notify_message'); ?>
	      		</p>
	      	</figure>
	     <figure class="top"></figure>
	     <figure class="left"></figure>
	     <figure class="right"></figure>
	     <figure class="bottom"></figure>
	    </div>
	  </section>
	<?php
	}
}

// create custom plugin settings menu
add_action('admin_menu', 'notify_create_menu');

function notify_create_menu() {

	add_options_page( 'Notify Settings', 'Notify', 'manage_options', 'notify', 'notify' ); 
	//call register settings function
	add_action( 'admin_init', 'notify_settings' );
}


function notify_settings() {
	global $time;
	//register our settings
	register_setting( 'notify-settings-group', 'notify_turnon' );
	register_setting( 'notify-settings-group', 'notify_fadein' );
	register_setting( 'notify-settings-group', 'notify_fadeout' );
	register_setting( 'notify-settings-group', 'notify_subject' );
	register_setting( 'notify-settings-group', 'notify_message' );
}
	
function notify() {
	global $time;
	global $next_time_to_sync;

    if (isset($_POST['action'])){
    		update_option( 'notify_turnon', $_POST['notify_turnon'] );
    		update_option( 'notify_subject', $_POST['notify_subject'] );
    		update_option( 'notify_message', $_POST['notify_message'] );
    	  	update_option( 'notify_fadein', $_POST['notify_fadein'] );
		    update_option( 'notify_fadeout', $_POST['notify_fadeout'] );
		    $form_result =  'Settings saved!';
	    }else{
        	//$form_result = 'Oops, error, please contact administrator';
        }
?>

<div class="wrap notify" style="display: none;">
<div class="inner">


  <?php if($_POST){ notify_add_wpfooter(); echo '<div class="arrow">Preview</div>'; } ?>

 <style>
	#cube{
		margin: 20px 0 0 60px !important;
	}
</style>

<div class="notifylogo">
	<img src="<?php echo plugins_url('images/logo.png', __FILE__) ?>"><span>Slick bubble text notification to your homepage</span></p>
</div>



<form method="post" id="save-theme" name="save-theme" action="" method="post">
   
   	<input type="hidden" name="notify_turnon" id="notify_turnon" value="<?php echo get_option('notify_turnon'); ?>" />
    	<input type="hidden" name="notify_fadein" id="notify_fadein" />
   	<input type="hidden" name="notify_fadeout" id="notify_fadeout" />
   	
   	
   	<a href="#" id="turnon" <?php if(get_option('notify_turnon') == 1){ ?>class="turnedon"<?php } ?>></a>   
	<div id="slider-range"></div>
	
	<h2>Fadein & Fadeout timeout</h2>
	<p>fadein <span class="notify_fadein"><?php echo get_option('notify_fadein'); ?></span> seconds & fadeout <span class="notify_fadeout"><?php echo get_option('notify_fadeout'); ?></span> seconds</p>
	
	<input type="text" name="notify_subject" id="notify_subject" value="<?php echo get_option('notify_subject'); ?>" /><br />
	<input type="text" name="notify_message" id="notify_message" value="<?php echo get_option('notify_message'); ?>" /><br />
	
	
	<?php settings_fields( 'notify-settings-group' ); ?>
    
    
    <?php if(isset($form_result)){ ?>
    <div class="settings-error updated"><p><strong><?php echo $form_result; ?></strong></p></div>
    <?php } ?>
    
  	<input type="submit" name="" class="submit" value="Save & Show Preview" />

<p class="copyright">&copy; Copyright by Ondřej Dadok (<a href="http://www.ondrejdadok.cz" target="_blank">Visit site</a>), <a href="mailto:info@a2media.cz">Send me email</a>, <a href="#" class="beer" rel="modal-profile">Buy me a beer</a>

</form>

</div>
</div>



<div class="modal-lightsout"></div>
<div class="modal-profile" style="display: none;">
    <h2><strong>I love to develop plugins</strong> to you <strong>for free!</strong></h2>
    <p><strong>But if you like this plugin and want to give me some bounty</strong> or you wish to sponsor some specific feature, you're welcome to <strong>send me a donation</strong>. All sponsors are published on the plugin page at the bottom. <strong>Thank you!</strong></p>
    
    <a href="#" title="Close donation" class="modal-close-profile"><img src="<?php echo plugins_url('images/close.png', __FILE__) ?>" alt="Close donation" /></a>
    
    <a href="#" class="customprice">Custom amount</a>
    
    <table class="donate-table">
    <tr>
    	
    	<td>
    	   	<img src="<?php echo plugins_url('images/gambrinus.png', __FILE__) ?>">
    	   	<h3>GAMB</h3> <span class="price"><strong>0.5</strong>€</span>
    	</td>
    	<td>
    	   	<img src="<?php echo plugins_url('images/budweiser.png', __FILE__) ?>">
    	   	<h3>BUDVAR</h3>  <span class="price"><strong>0.5</strong>€</span>
    	</td>
    	<td>
	    	<img src="<?php echo plugins_url('images/heineken.png', __FILE__) ?>">
	    	<h3>HEINEKEN</h3> <span class="price"><strong>1.0</strong>€</span>
    	</td>
    	<td class="current-donate">
	    	<img src="<?php echo plugins_url('images/pilsner12.png', __FILE__) ?>">
	    	<h3>PLZEŇ</h3> <span class="price"><strong>2.0</strong>€</span>
    	</td>
    	    	
    	<td>
    		<img src="<?php echo plugins_url('images/stellaartois.png', __FILE__) ?>">
    		<h3>STELLA</h3> <span class="price"><strong>2.5</strong>€</span>
    
    	    </tr>
    </table>
    
    
        
    
    
    
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="donate_form">
	    <input type="hidden" name="cmd" value="_donations">
	    <input type="hidden" name="business" value="info@ondrejdadok.cz">
	    <input type="hidden" name="lc" value="US">
	    <input type="hidden" name="item_name" value="Notify Donation">
	    <div id="amount_cont">
	    <input type="text" name="amount" value="2.0" id="amount" size="2" maxlength="4"> <span>€</span>
	    </div>
	    <input type="text" name="item_number" value="First & Last Name, message.." id="name" onclick="this.value=''">
	    <input type="hidden" name="no_note" value="0">
	    <input type="hidden" name="currency_code" value="EUR">
	    <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest">
	    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" id="submit_donate">
	    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
    
</div>

<?php
include "lib/sponsors.php";
} 
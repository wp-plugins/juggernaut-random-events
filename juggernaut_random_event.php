<?php
	/*
	Plugin Name: JuggernautPlugins - Random Event
	Plugin URI: http://juggernautplugins.com
	Description: Create random events anywhere on your website to get your visitors excited while increasing your page views, time on site, and customer loyalty. You can give away anything you want to reward visitors with a free report, product, software license or coupon code with Juggernaut Random Events. You also get to choose the how often your random events are triggered and what pages they will show up on.
	Version: 1.3
	Author: JuggernautPlugins
	Author URI: http://www.juggernautplugins.com/
	Text-Domain: ari
	*/

	/* 
		Codename: Ari
		01:12/4/14
	*/

	// Roll the dice!
	function ari_roll_the_dice() 
	{

		$rando = 0;
		$bait = 0;
		//$viewcount = 0; // get_option(viewcount);

		$chance = get_option('ari_chance');
		
		switch($chance)
		{
			case '1' :
				$rando = mt_rand( 1 , 100 );
				$bait = 20;
			break;

			case '5' :
				$rando = mt_rand( 1 , 20 );
				$bait = 15;
			break;

			case '10' :
				$rando = mt_rand( 1 , 10 );
				$bait = 5;
			break;

			case '20' :
				$rando = mt_rand( 1 , 6 );
				$bait = 3;
			break;

			case '25' :
				$rando = mt_rand( 1 , 4 );
				$bait = 2;
			break;

			case '100' :
				$rando = 9;
				$bait = 9;
			break;
		}

		if ( $rando == $bait )
		{
			// HIT!
			ari_pop_up();
			// update viewcount
			//$viewcount = $viewcount + 1; // $post->meta['viewcount'];
			// update_option(viewcount)
		}
	}

	function ari_pop_up()
	{
		$wpre_title = stripslashes( get_option( 'ari_title' ) );
		$wpre_image = stripslashes( get_option( 'ari_image' ) );
		$wpre_description = stripslashes( get_option( 'ari_description' ) );
		$wpre_chance = stripslashes( get_option( 'ari_chance' ) );
		$wpre_cta = stripcslashes( get_option( 'ari_cta' ) );
		$wpre_landing_page = stripcslashes( get_option( 'ari_landing_page' ) );
		$wpre_location = stripslashes( get_option( 'ari_location' ) );
		$location = $wpre_location;

		if ( $wpre_title == '' ) { $wpre_title = 'Whoa! You found Something!'; }
		if ( $wpre_description == '' ) { $wpre_description = 'Lucky you... it looks like you just randomly found a 10% off coupon code on the ground! SWEET!'; }
		if ( $wpre_cta == '' ) { $wpre_cta = 'Click here to claim your code and keep shopping...'; }
		if ( $wpre_landing_page == '' ) { $wpre_landing_page = '/contact'; }
		if ( $wpre_image == '' ) { $wpre_image = '/wp-content/plugins/ari/images/JUGGERNAUT-RANDOM-EVENTS-LOGO.jpg'; }
		if ( $wpre_chance == '' ) { $wpre_chance = '25'; }
		if ( $wpre_location == '' ) { $wpre_location = 'modal'; }
		if ( $wpre_location == 'random' )
		{
			$loco = mt_rand(1,6);
		} else {
			$loco = $location;
		}

		$ari_container = '<script src="/wp-content/plugins/ari/ari.js"></script>';

		switch($loco)
		{

			case '1':
			case 'tl':
				$location = 'wpre_top_left';
			break;

			case '2':
			case 'tc':
				$location = 'wpre_top_center';
			break;

			case '3':
			case 'tr':
				$location = 'wpre_top_right';
			break;

			case '4':
			case 'bl':
				$location = 'wpre_bottom_left';
			break;

			case '5':
			case 'bc':
				$location = 'wpre_bottom_center';
			break;

			case '6':
			case 'br':
				$location = 'wpre_bottom_right';
			break;

			case 'modal':
				$location = 'wpre_modal';
				$ari_container .= '<div class="wpre_modal_overlay" id="ari_modal_overlay"></div>';
			break;
		}

		$ari_container .= 
			'<div class="wpre_container '.$location.'" id="ari_container">
				<h3 class="wpre_title">'.$wpre_title.' <span href="" id="wpre_close" onclick="wpre_close()">close</span></h3>
				<img class="wpre_image" src="'.$wpre_image.'" />
				<p class="wpre_description">'.$wpre_description.'</p>
				<a href="'.$wpre_landing_page.'" class="wpre_cta">'.$wpre_cta.'</a>
				<p><span id="wpre_close" onclick="wpre_close()">No, thank you</span></p>
			</div>
			';

		echo $ari_container;
	}

	function ari_show_your_style()
	{
		wp_enqueue_style( 'ariswag', plugins_url( 'ari.css' , __FILE__ ));
	}

	add_action( 'wp_enqueue_scripts', 'ari_show_your_style' );
	add_action( 'wp_footer', 'ari_roll_the_dice', 100 );
	add_action( 'admin_menu', 'ari_build_your_settings_page' );

	function ari_build_your_settings_page()
	{
		add_options_page( 'Ari - Thats Random', 'Random Event', 'edit_theme_options', 'ari', 'ari_admin_settings');
	}

	function ari_admin_settings()
	{
		// some defaults
		$ari_title = get_option('ari_title');
		$ari_description = get_option('ari_description');
		$ari_cta = get_option('ari_cta');
		$ari_landing_page = get_option('ari_landing_page');
		$ari_image = get_option('ari_image');
		$ari_chance = get_option('ari_chance');
		$ari_location = get_option('ari_location');

		if ( $ari_title == '' ) { $ari_title = 'Whoa! You found Something!'; }
		if ( $ari_description == '' ) { $ari_description = 'Lucky you... it looks like you just randomly found a 10% off coupon code on the ground! SWEET!'; }
		if ( $ari_cta == '' ) { $ari_cta = 'Click here to claim your code and keep shopping...'; }
		if ( $ari_landing_page == '' ) { $ari_landing_page = '/contact'; }
		if ( $ari_image == '' ) { $ari_image = '/wp-content/plugins/ari/images/JUGGERNAUT-RANDOM-EVENTS-LOGO.jpg'; }
		if ( $ari_chance == '' ) { $ari_chance = '25'; }
		if ( $ari_location == '' ) { $ari_location = 'random'; }

		if ( isset($_POST['ari_options_update']) && $_POST['ari_options_update'] == 'yes' ) 
		{ 
			// update all the options!
			$ari_title = update_option('ari_title', $_POST['ari_title']);
			$ari_description = update_option('ari_description', $_POST['ari_description']);
			$ari_cta = update_option('ari_cta',$_POST['ari_cta']);
			$ari_landing_page = update_option('ari_landing_page', $_POST['ari_landing_page']);
			$ari_image = update_option('ari_image', $_POST['ari_image']);
			$ari_chance = update_option('ari_chance', $_POST['ari_chance']);
			$ari_location = update_option('ari_location', $_POST['ari_location']);
			// display new data for variables
			// if isset $_POST['ari_title'] ? $ari_title = $_POST['ari_title'] : $ari_title = $get_option('ari_title')
			$ari_title = $_POST['ari_title'];
			$ari_description = $_POST['ari_description'];
			$ari_cta = $_POST['ari_cta'];
			$ari_landing_page = $_POST['ari_landing_page'];
			$ari_image = $_POST['ari_image'];
			$ari_chance = $_POST['ari_chance'];
			$ari_location = $_POST['ari_location'];
		} 
	?>

		<div class="wrap">
			<h2>Random Event Configuration</h2>
			<form action="" method="post">
				<input type="hidden" value="yes" name="ari_options_update" />
				<div id="poststuff">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="post-body-content">
							<h2>Event Title</h2>
							<input type="text" name="ari_title" size="30" value="<?php echo $ari_title; ?>" class="wpre_input" />

							<h2>Event Description</h2>
							<textarea class="wp-editor-area" style="height: 80px; margin-top: 7px; color: #000000; width: 440px; text-align:center;" name="ari_description"><?php echo $ari_description; ?></textarea>

							<h2>Call To Action</h2>
							<input type="text" name="ari_cta" size="30" value="<?php echo $ari_cta; ?>" class="wpre_input" autocomplete="off" />

							<h2>Page URL to direct link to</h2>
							<input type="text" name="ari_landing_page" size="30" value="<?php echo $ari_landing_page; ?>" class="wpre_input" autocomplete="off" />

							<h2>Ad an Image</h2>
							<input id="upload_image" type="text" size="36" name="ari_image" value="<?php echo $ari_image ?>" /> Enter a URL or upload an image for the banner. <br />
							<input id="upload_image_button" type="button" value="Upload Image"/><br />
							<div class="logo_placeholder"><?php if ( $ari_image != '' ) { ?><img src="<?php echo $ari_image; ?>" alt="" /><?php } ?></div>

							<h2>Chance of Accurance</h2>
							<ul>
								<li><input type="radio" id="1" value="1" name="ari_chance" <?php if ( $ari_chance == 1 ) { echo "checked"; } ?> ><label for="1">1%</label></li>
								<li><input type="radio" id="5" value="5" name="ari_chance" <?php if ( $ari_chance == 5 ) { echo "checked"; } ?> ><label for="5">5%</label></li>
								<li><input type="radio" id="10" value="10" name="ari_chance" <?php if ( $ari_chance == 10 ) { echo "checked"; } ?> ><label for="10">10%</label></li>
								<li><input type="radio" id="20" value="20" name="ari_chance" <?php if ( $ari_chance == 20 ) { echo "checked"; } ?> ><label for="20">20%</label></li>
								<li><input type="radio" id="25" value="25" name="ari_chance" <?php if ( $ari_chance == 25 ) { echo "checked"; } ?> ><label for="25">25%</label></li>
								<li><input type="radio" id="100" value="100" name="ari_chance" <?php if ( $ari_chance == 100 ) { echo "checked"; } ?> ><label for="100">100%</label><br /></li>
							</ul>

							<h2>Location</h2>
							<ul>
								<li><input type="radio" id="location_modal" value="modal" name="ari_location" <?php if ( $ari_location == 'modal' ) { echo "checked"; } ?>/><label for="location_modal">Modal</label></li>
								<li><input type="radio" id="location_random" value="random" name="ari_location" <?php if ( $ari_location == 'random' ) { echo "checked"; } ?>/><label for="location_random">Random</label></li>
								<li><input type="radio" id="location_tl" value="tl" name="ari_location" <?php if ( $ari_location == 'tl' ) { echo "checked"; } ?> /><label for="location_tl">Top Left</label></li>
								<li><input type="radio" id="location_tc" value="tc" name="ari_location" <?php if ( $ari_location == 'tc' ) { echo "checked"; } ?> /><label for="location_tc">Top Center</label></li>
								<li><input type="radio" id="location_tr" value="tr" name="ari_location" <?php if ( $ari_location == 'tr' ) { echo "checked"; } ?> /><label for="location_tr">Top Right</label></li>
								<li><input type="radio" id="location_bl" value="bl" name="ari_location" <?php if ( $ari_location == 'bl' ) { echo "checked"; } ?> /><label for="location_bl">Bottom Left</label></li>
								<li><input type="radio" id="location_bc" value="bc" name="ari_location" <?php if ( $ari_location == 'bc' ) { echo "checked"; } ?> /><label for="location_bc">Bottom Center</label></li>
								<li><input type="radio" id="location_br" value="br" name="ari_location" <?php if ( $ari_location == 'br' ) { echo "checked"; } ?> /><label for="location_br">Bottom Right</label></li>
							</ul>	
							<?php submit_button(); ?>			
						</div><!-- /post-body-content -->
					<div class="clear"></div></div><!-- wpbody-content -->
				<div class="clear"></div></div><!-- wpbody -->
			</form>
		<?
	}

	add_action('admin_enqueue_scripts', 'ari_admin_scripts');
	 
	function ari_admin_scripts() {
		if ( isset($_GET['page']) ) {
		    if ( $_GET['page'] == 'ari' ) {
		        wp_enqueue_media();
		        wp_enqueue_style( 'ari-admin', '/wp-content/plugins/ari/resources/ari_admin.css' );
		        wp_register_script('ari-admin-js', '/wp-content/plugins/ari/resources/ari_admin.js', array('jquery'));
		        wp_enqueue_script('ari-admin-js');
		    }
		}
	}
?>
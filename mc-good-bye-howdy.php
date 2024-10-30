<?php
/*
Plugin Name: MC Good-bye Howdy
Plugin URI: https://Mid-Coast.com/mc-good-bye-howdy
Description: Remove "Howdy" or replace it with Your Own Greeting, Your Own List of Random Greetings, Good Morning/Afternoon/Evening, Today's Day and Date, Random International Greetings, or Random Positive Phrases.
Version: 2.6.5
Author: Mike Hickcox
Author URI: https://Mid-Coast.com
License: GPLv3
License URI: https://www.gnu.org/licenses

    Copyright (C)2024  Mike Hickcox

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program. If not, see https://www.gnu.org/licenses.
*/

	if ( ! defined( 'ABSPATH' ) ) exit;


	//Add A SETTINGS LINK TO THE PLUGIN LISTING ON THE INSTALLED PLUGINS LIST

	function mc6397gh_plugin_settings_link($mc6397gh_links) { 
  	$mc6397gh_settings_link = '<a href="options-general.php?page=mc6397ghPlugin">Settings</a>'; 
  	array_unshift($mc6397gh_links, $mc6397gh_settings_link); 
  	return $mc6397gh_links; 
}
	$mc6397gh_plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$mc6397gh_plugin", 'mc6397gh_plugin_settings_link' );



	// ADD AN OPTIONS PAGE AND AN ITEM UNDER SETTINGS

	class mc6397ghPlugin_Settings_Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'mc6397gh_create_settings' ) );
		add_action( 'admin_init', array( $this, 'mc6397gh_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'mc6397gh_setup_fields' ) );
	}

	public function mc6397gh_create_settings() {
		$mc6397gh_page_title = 'Settings for MC Good-bye Howdy';
		$mc6397gh_menu_title = 'MC Good-bye Howdy';
		$mc6397gh_capability = 'manage_options';
		$mc6397gh_slug = 'mc6397ghPlugin';
		$mc6397gh_callback = array($this, 'mc6397gh_settings_content');
		add_options_page($mc6397gh_page_title, $mc6397gh_menu_title, $mc6397gh_capability, $mc6397gh_slug, $mc6397gh_callback);
	}

	// CREATE THE FORM

	public function mc6397gh_settings_content() { ?>
		<div class="wrap">
			<img src="<?php echo plugin_dir_url( __FILE__ ) . 'assets/MC-GH-Head.jpg'; ?>">
			<h1>Settings for MC Good-bye Howdy</h1>
			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'mc6397ghPlugin' );
					do_settings_sections( 'mc6397ghPlugin' );
					submit_button();
				?>
			</form>
		</div> <?php
	}

	public function mc6397gh_setup_sections() {
		add_settings_section( 'mc6397ghPlugin_section', 'Choose whatever you want to replace "Howdy" at the top-right of your admin pages.', array(), 'mc6397ghPlugin' );
	}

	public function mc6397gh_setup_fields() {
		$mc6397gh_fields = array(
			array(
				'label' => 'Select Greeting Type',
				'id' => 'mc6397gh_Type',
				'type' => 'select',
				'section' => 'mc6397ghPlugin_section',
				'options' => array(
					'remove' => 'Just Remove "Howdy"',
					'personal' => 'My Own Personal Greeting',
					'personalrandom' => 'My Own Random Greeting List',
					'daypart' => 'Greet by Daypart',
					'today' => "Today's Day and Date",
					'international' => 'Random International Greeting',
					'phrase' => 'Random Positive Phrase',
				),
				'desc' => 'Choose anything on the list and save it by clicking the <strong>Save Changes</strong> button below. <br/> Date and time choices will function according to the time zone you selected in the website <strong>General Settings</strong>.<br/>If you choose "My Own Personal Greeting" or "My Own Random Greeting List", fill in the appropriate field below.',
				'placeholder' => 'Just Remove "Howdy"',
			),

			array(
				'label' => 'New Personal Greeting',
				'id' => 'mc6397gh_Personal',
				'type' => 'text',
				'section' => 'mc6397ghPlugin_section',
				'desc' => ' Used when "My Own Personal Greeting" is selected above.',
				'placeholder' => 'Write Your Greeting',
			),

			array(
				'label' => 'My Own Random Greeting List',
				'id' => 'mc6397gh_MyList',
				'type' => 'text',
				'section' => 'mc6397ghPlugin_section',
				'desc' => ' Used when "My Own Random Greeting List" is selected above.<br/><strong>EXAMPLE:  Welcome back, Glad to see you, Have a great day</strong><br/>NOTE: Separate the words or phrases with a comma.',
				'placeholder' => 'Type Your List',
			),

		);
		foreach( $mc6397gh_fields as $mc6397gh_field ){
			add_settings_field( $mc6397gh_field['id'], $mc6397gh_field['label'], array( $this, 'mc6396gh_field_callback' ), 'mc6397ghPlugin', $mc6397gh_field['section'], $mc6397gh_field );
			register_setting( 'mc6397ghPlugin', $mc6397gh_field['id'] );
		}
	}

	public function mc6396gh_field_callback( $mc6397gh_field ) {
		$mc6397gh_value = esc_attr(get_option( $mc6397gh_field['id'] ));
		$mc6397gh_placeholder = '';
		if ( isset($mc6397gh_field['placeholder']) ) {
			$mc6397gh_placeholder = $mc6397gh_field['placeholder'];
		}
		switch ( $mc6397gh_field['type'] ) {
				case 'select':
				case 'multiselect':
					if( ! empty ( $mc6397gh_field['options'] ) && is_array( $mc6397gh_field['options'] ) ) {
						$mc6397gh_attr = '';
						$mc6397gh_options = '';
						foreach( $mc6397gh_field['options'] as $mc6397gh_key => $mc6397gh_label ) {
							$mc6397gh_options.= sprintf('<option value="%s" %s>%s</option>',
								$mc6397gh_key,
								selected($mc6397gh_value, $mc6397gh_key, false),
								$mc6397gh_label
							);
						}
						if( $mc6397gh_field['type'] === 'multiselect' ){
							$mc6397gh_attr = ' multiple="multiple" ';
						}
						printf( '<select name="%1$s" id="%1$s" %2$s>%3$s</select>',
							$mc6397gh_field['id'],
							$mc6397gh_attr,
							$mc6397gh_options
						);
					}
					break;
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$mc6397gh_field['id'],
					$mc6397gh_field['type'],
					$mc6397gh_placeholder,
					$mc6397gh_value
				);
		}
		if( isset($mc6397gh_field['desc']) ) {
			if( $mc6397gh_desc = $mc6397gh_field['desc'] ) {
				printf( '<p class="description">%s </p>', $mc6397gh_desc );
			}
		}
	}
}
	new mc6397ghPlugin_Settings_Page();



	// REPLACE HOWDY WITH ONE OF SIX MODES

	// CHOICE ONE: JUST REMOVE "HOWDY"

	if (get_option('mc6397gh_Type') == 'remove') {

	function mc6397gh_replace( $mc6397gh_wp_admin_bar ) {
   	$mc6397gh_my_account=$mc6397gh_wp_admin_bar->get_node('my-account');
 	$mc6397gh_greeting = " ";
    	$mc6397gh_newtitle = str_replace( 'Howdy,', $mc6397gh_greeting , $mc6397gh_my_account->title );
    	$mc6397gh_wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $mc6397gh_newtitle,
    ) );
}}

	// CHOICE TWO: CREATE MY OWN PERSONAL GREETING

	if (get_option('mc6397gh_Type') == 'personal') {

	function mc6397gh_replace( $mc6397gh_wp_admin_bar ) {
   	$mc6397gh_my_account=$mc6397gh_wp_admin_bar->get_node('my-account');
 	$mc6397gh_greeting = esc_html(get_option('mc6397gh_Personal'));
    	$mc6397gh_newtitle = str_replace( 'Howdy,', $mc6397gh_greeting , $mc6397gh_my_account->title );
    	$mc6397gh_wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $mc6397gh_newtitle,
    ) );
}}

	// CHOICE THREE: CREATE MY OWN RANDOM LIST

	if (get_option('mc6397gh_Type') == 'personalrandom') {

	function mc6397gh_replace( $mc6397gh_wp_admin_bar ) {
   	$mc6397gh_my_account=$mc6397gh_wp_admin_bar->get_node('my-account');
 	$mc6397gh_Rand1 = esc_html(get_option('mc6397gh_MyList')) ;
	$mc6397gh_Rand = explode( ',', $mc6397gh_Rand1 );
     	$mc6397gh_RandIndex = array_rand($mc6397gh_Rand, 1);
	$mc6397gh_Int = $mc6397gh_Rand[$mc6397gh_RandIndex];
    	$mc6397gh_newtitle = str_replace( 'Howdy', $mc6397gh_Int, $mc6397gh_my_account->title );
    	$mc6397gh_wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $mc6397gh_newtitle,		
    ) );
}}



	// CHOICE FOUR: GREET BY DAYPART, ACCORDING TO WEBSITE'S TIME ZONE

	if (get_option('mc6397gh_Type') == 'daypart') {

	function mc6397gh_replace( $mc6397gh_wp_admin_bar ) {
   	$mc6397gh_my_account=$mc6397gh_wp_admin_bar->get_node('my-account');

		$mc6397gh_time=current_time("H");

		if (($mc6397gh_time >= "00") && ($mc6397gh_time < "01")) {
  		$mc6397gh_DayGreeting = "Welcome to the Midnight Hour,";
} 
		if (($mc6397gh_time >= "01") && ($mc6397gh_time < "12")) {
  		$mc6397gh_DayGreeting = "Good Morning,";
} 
		elseif (($mc6397gh_time >= "12") && ($mc6397gh_time < "18")) {
  		$mc6397gh_DayGreeting = "Good Afternoon,";
}
		elseif (($mc6397gh_time >= "18") && ($mc6397gh_time < "24")) {
  		$mc6397gh_DayGreeting = "Good Evening,";
}
    	$mc6397gh_newtitle = str_replace( 'Howdy,', $mc6397gh_DayGreeting, $mc6397gh_my_account->title );
		$mc6397gh_wp_admin_bar->add_node( array(
		'id' => 'my-account',
		'title' => $mc6397gh_newtitle,) );
}}


	// CHOICE FIVE: DISPLAY TODAY'S DAY AND DATE, ACCORDING TO WEBSITE'S TIME ZONE

	if (get_option('mc6397gh_Type') == 'today') {

	function mc6397gh_replace( $mc6397gh_wp_admin_bar ) {
   	$mc6397gh_my_account=$mc6397gh_wp_admin_bar->get_node('my-account');
	$mc6397gh_Today=current_time("l, F j, Y") . "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
    	$mc6397gh_newtitle = str_replace( 'Howdy,', $mc6397gh_Today, $mc6397gh_my_account->title );
		$mc6397gh_wp_admin_bar->add_node( array(
		'id' => 'my-account',
		'title' => $mc6397gh_newtitle,) );
}}



	// CHOICE SIX: RANDOM INTERNATIONAL GREETING

	if (get_option('mc6397gh_Type') == 'international') {

	function mc6397gh_replace( $mc6397gh_wp_admin_bar ) {
   	$mc6397gh_my_account=$mc6397gh_wp_admin_bar->get_node('my-account');
		$mc6397gh_Rand = array("Ahlan,", "Aloha,", "Anyoung,", "Bonjour,", "Ciao,", "Chow,", "Greetings,", "God dag,", "Guten Tag,", "Habari,", "Hej,", "Hola,", "Hello,", "Konnichiwa,", "Olá,", "Privet,", "¿Qué tal?,", "Salut,", "Selam,", "Shalom,", "Watij,", "Yassou,");
		$mc6397gh_RandIndex = array_rand($mc6397gh_Rand);
		$mc6397gh_Int = $mc6397gh_Rand[$mc6397gh_RandIndex];
    	$mc6397gh_newtitle = str_replace( 'Howdy,', $mc6397gh_Int, $mc6397gh_my_account->title );
    	$mc6397gh_wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $mc6397gh_newtitle,		
    ) );
}}

	// CHOICE SEVEN: GREET BY RANDOM POSITIVE PHRASE

	if (get_option('mc6397gh_Type') == 'phrase') {

	function mc6397gh_replace( $mc6397gh_wp_admin_bar ) {
   	$mc6397gh_my_account=$mc6397gh_wp_admin_bar->get_node('my-account');
		$mc6397gh_Rand = array("And the winner is:", "Astonish us,", "Attaway,", "Do your thing,", "First class work,", "Keep it up,", "Love your work,", "Make my day,", "Our favorite editor:", "Really nice work,", "Right on,", "Today is your day,", "We appreciate you,", "We believe in you,", "We're impressed,", "WordPress loves", "You amaze us,", "You can do it,", "You don't miss a thing,", "You're the best,", "You're a superhero,", "You rock,");
		$mc6397gh_RandIndex = array_rand($mc6397gh_Rand);
		$mc6397gh_Phrase = $mc6397gh_Rand[$mc6397gh_RandIndex];
    	$mc6397gh_newtitle = str_replace( 'Howdy,', $mc6397gh_Phrase, $mc6397gh_my_account->title );
    	$mc6397gh_wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $mc6397gh_newtitle,
    ) );
}}

	// CHANGE THE GREETING

	add_filter( 'admin_bar_menu', 'mc6397gh_replace',9992 ); 

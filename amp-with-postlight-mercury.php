<?php
/**
 * Plugin Name: AMP With Postlight Mercury
 * Plugin URI: https://morgvanny.com
 * Description: This plugin adds some code to your page headers, letting Postlight provide an AMP solution for you, using their tool, Mercury.
 * Version: 1.1.0
 * Author: Morgan VanYperen
 * Author URI: https://morgvanny.com
 * License: GPLv3
 */


add_action( 'admin_menu', 'ampwpm_add_admin_menu' );
add_action( 'admin_init', 'ampwpm_settings_init' );

function ampwpm_add_admin_menu(  ) { 
  add_menu_page( 'AMP With Postlight Mercury', 'AMP With Postlight Mercury', 'manage_options', 'amp_with_postlight_mercury', 'ampwpm_options_page' );
}

function ampwpm_settings_init(  ) { 
  register_setting( 'pluginPage', 'ampwpm_settings' );
  add_settings_section(
    'ampwpm_pluginPage_section', 
    __( '<a href="http://mercury.postlight.com/">Learn More About How Postlight is Helping With AMP</a>', 'wordpress' ), 
    'ampwpm_settings_section_callback', 
    'pluginPage'
  );
  add_settings_field( 
    'ampwpm_checkbox_field_0',
    __( 'I agree to Postlight Mercury\'s <a href="http://mercury.postlight.com/tos">Terms of Service</a>.', 'wordpress' ), 
    'ampwpm_checkbox_field_0_render', 
    'pluginPage', 
    'ampwpm_pluginPage_section' 
  );
}

function ampwpm_checkbox_field_0_render(  ) { 
  $options = get_option( 'ampwpm_settings' );
  ?>
  <input type='checkbox' name='ampwpm_settings[ampwpm_checkbox_field_0]' <?php checked( $options['ampwpm_checkbox_field_0'], 1 ); ?> value='1'>
  <?php
}

function ampwpm_settings_section_callback(  ) { 
  echo __( 'Before using Mercury, please be sure you have read and agreed to the terms of service. You must do this in order to use Mercury!', 'wordpress' );
}

function ampwpm_options_page(  ) { 
  ?>
  <form action='options.php' method='post'>
    <h2>AMP With Postlight Mercury</h2>
    <?php
    settings_fields( 'pluginPage' );
    do_settings_sections( 'pluginPage' );
    submit_button();
    ?>
  </form>
  <?php
}

if ( get_option( 'ampwpm_settings' )['ampwpm_checkbox_field_0'] == 1 ) {
  add_action( 'wp_head', 'my_mercury_tag' );
  
  function my_mercury_tag() {
    if( is_single() ) {
      ?>
      <link rel="amphtml" href="https://mercury.postlight.com/amp?url=<?php echo urlencode(get_the_permalink()); ?>">
      <?php
    }
  }
}

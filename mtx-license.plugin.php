<?php
/* 
Plugin Name: mtx License Box
Description: This plugin adds a box containing the license at the end of each article
Version: 1.0
Author: Maurizio Tarchini
Author URI: http://www.mtxweb.ch
 */

// ================== ADD LICENSE ================== //
add_filter('the_content', 'ylb_output_license_box');

function ylb_output_license_box($content)
{

   $return = $content;
   $return .= '<div class="ylb-container" style="background-color:' . get_option('ylb_box_bg_color') . '">
                   <a href="#" class="ylb-close"><img src="' . WP_PLUGIN_URL . '/mtx-license-plugin/images/close-icon.png" /></a>
				   <p>' . get_option('ylb_license_content') . '</p>
               </div>';
   return $return;
}

// ================== END ADD LICENSE ================= //


// ==================== PRINT JAVASCRIPT VAR ============ //
function ylb_print_javascript_var()
{
   ?>
       <script type="text/javascript">
           var effectType = '<?php echo get_option('ylb_close_box_effect'); ?>';
       </script>
   <?php
}

add_action ('wp_print_scripts', 'ylb_print_javascript_var');
// ================== END PRINT JAVASCRIPT VAR ================ //


// ======================= ENQUEUE REQUIRED SCRIPT AND STYLE ====================================== //
function ylb_enqueue_required_scripts()
{
    wp_enqueue_style('ylb-style', WP_PLUGIN_URL . '/mtx-license-plugin/css/style.css');
    wp_enqueue_script('ylb-custom-script', WP_PLUGIN_URL . '/mtx-license-plugin/js/custom.js', array('jquery'));
}
add_action('init', 'ylb_enqueue_required_scripts');
// ======================= END ENQUEUE REQUIRED SCRIPT AND STYLE ================================ //

// ======================== SET DEFAULT OPTION ON PLUGIN ACTIVATION =============================== //
function ylb_activate_set_default_options()
{
   add_option('ylb_license_content', 'Enter the text of the license here');
   add_option('ylb_close_box_effect', 'slideup');
   add_option('ylb_box_bg_color', 'E6E6E6');
}

register_activation_hook( __FILE__, 'ylb_activate_set_default_options');
// ========================= END SET DEFAULT OPTION ON PLUGIN ACTIVATION ========================== //

// ======================== SET OPTIONS GROUP =================================== //
function ylb_register_options_group()
{
   register_setting('ylb_options_group', 'ylb_license_content');
   register_setting('ylb_options_group', 'ylb_close_box_effect');
   register_setting('ylb_options_group', 'ylb_box_bg_color');
}

add_action ('admin_init', 'ylb_register_options_group');
// ====================== END SET OPTIONS GROUP ================================ //


// ===================== CREATE AND ADD OPTTION PAGE =================================== //
function ylb_add_option_page()
{
   add_options_page('YLB Options', 'YLB Options', 'administrator', 'ylb-options-page', 'ylb_update_options_form');
}

add_action('admin_menu', 'ylb_add_option_page');

function ylb_update_options_form()
{
   ?>
   <div class="wrap">
       <div class="icon32" id="icon-options-general"><br /></div>
       <h2>License Box Configuration</h2>
       <p>&nbsp;</p>
       <form method="post" action="options.php">
           <?php settings_fields('ylb_options_group'); ?>
           <table class="form-table">
               <tbody>
                   <tr valign="top">
                   <th scope="row"><label for="ylb_box_bg_color">Box Color:</label></th>
                       <td>
                           <input type="text" id="ylb_box_bg_color" value="<?php echo get_option('ylb_box_bg_color'); ?>" name="ylb_box_bg_color" />
                           <div id="ylb-colorpicker"></div>    
                       </td>
                   </tr>
                   <tr valign="top">
                       <th scope="row"><label for="ylb_close_box_effect">Effect of closure of the box</label></th>
                           <td>
                               <select id="ylb_close_box_effect" name="ylb_close_box_effect">
                                   <option value="slideup" <?php selected(get_option('ylb_close_box_effect'), "slideup"); ?>>Slide Up </option>
                                   <option value="fadeout" <?php selected(get_option('ylb_close_box_effect'), "fadeout"); ?>>Fade Out </option>
                               </select>
                               <span class="description"></span>    
                           </td>
                   </tr>
           
                   <tr valign="top">
                       <th scope="row"><label for="ylb_license_content">License Text</label></th>
                           <td>
                               <textarea id="ylb_license_content" name="ylb_license_content" style="width:400px; height:200px"><?php echo get_option('ylb_license_content'); ?></textarea>
                               <span class="description"></span>    
                           </td>
                   </tr>
                   <tr valign="top">
                       <th scope="row"></th>
                           <td>
                               <p class="submit">
                                   <input type="submit" class="button-primary" id="submit" name="submit" value="<?php _e('Save Changes') ?>" />
                               </p>
                           </td>
                   </tr>
               </tbody>
           </table>
           
       </form>
   </div>
   <?php
}
// =============================== END CREATE AND ADD OPTION PAGE =============================== //

// =============================== ADD COLORPICKER ======================================== //

function ylb_farbtastic_load()
{
  wp_enqueue_style( 'farbtastic' );
  wp_enqueue_script( 'farbtastic' );
}

function ylb_colorpicker_custom_script()
{
	?>
	<script type="text/javascript">
 
  		jQuery(document).ready(function() {
    		jQuery('#ylb-colorpicker').hide();
    		jQuery('#ylb-colorpicker').farbtastic("#ylb_box_bg_color");
    		jQuery("#ylb_box_bg_color").click(function(){jQuery('#ylb-colorpicker').slideToggle()});
  		});
 
	</script>
	<?php
}
if(isset($_GET['page']) AND $_GET['page'] == 'ylb-options-page')
{
	add_action('init', 'ylb_farbtastic_load');
	add_action('admin_footer', 'ylb_colorpicker_custom_script');
}

// ================================ END ADD COLORPICKER ===================================== //
?>
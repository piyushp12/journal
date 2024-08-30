<?php

/**
 * Aster Storefront functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package aster_storefront
 */

$aster_storefront_theme_data = wp_get_theme();
if (! defined('ASTER_STOREFRONT_THEME_VERSION')) define('ASTER_STOREFRONT_THEME_VERSION', $aster_storefront_theme_data->get('Version'));
if (! defined('ASTER_STOREFRONT_THEME_NAME')) define('ASTER_STOREFRONT_THEME_NAME', $aster_storefront_theme_data->get('Name'));
if (! defined('ASTER_STOREFRONT_THEME_TEXTDOMAIN')) define('ASTER_STOREFRONT_THEME_TEXTDOMAIN', $aster_storefront_theme_data->get('TextDomain'));


/**
 * Include wptt webfont loader.
 */
require_once get_theme_file_path('theme-library/function-files/wptt-webfont-loader.php');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/theme-library/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/theme-library/function-files/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/theme-library/function-files/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/theme-library/customizer.php';

/**
 * Google Fonts
 */
require get_template_directory() . '/theme-library/function-files/google-fonts.php';

/**
 * Dynamic CSS
 */
require get_template_directory() . '/theme-library/dynamic-css.php';

/**
 * Breadcrumb
 */
require get_template_directory() . '/theme-library/function-files/class-breadcrumb-trail.php';

/**
 * Getting Started
 */
require get_template_directory() . '/theme-library/getting-started/getting-started.php';


if (! defined('ASTER_STOREFRONT_VERSION')) {
   define('ASTER_STOREFRONT_VERSION', '1.0.0');
}

if (! function_exists('aster_storefront_setup')) :

   function aster_storefront_setup()
   {

      load_theme_textdomain('aster-storefront', get_template_directory() . '/languages');

      add_theme_support('woocommerce');

      add_theme_support('automatic-feed-links');

      add_theme_support('title-tag');

      add_theme_support('post-thumbnails');

      register_nav_menus(
         array(
            'primary' => esc_html__('Primary', 'aster-storefront'),
         )
      );

      add_theme_support(
         'html5',
         array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
            'woocommerce',
         )
      );

      add_theme_support(
         'custom-background',
         apply_filters(
            'aster_storefront_custom_background_args',
            array(
               'default-color' => 'ffffff',
               'default-image' => '',
            )
         )
      );

      add_theme_support('customize-selective-refresh-widgets');

      add_theme_support(
         'custom-logo',
         array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
         )
      );

      add_theme_support('align-wide');

      add_theme_support('responsive-embeds');
   }
endif;
add_action('after_setup_theme', 'aster_storefront_setup');

function aster_storefront_content_width()
{
   $GLOBALS['content_width'] = apply_filters('aster_storefront_content_width', 640);
}
add_action('after_setup_theme', 'aster_storefront_content_width', 0);

function aster_storefront_widgets_init()
{
   register_sidebar(
      array(
         'name'          => esc_html__('Sidebar', 'aster-storefront'),
         'id'            => 'sidebar-1',
         'description'   => esc_html__('Add widgets here.', 'aster-storefront'),
         'before_widget' => '<section id="%1$s" class="widget %2$s">',
         'after_widget'  => '</section>',
         'before_title'  => '<h2 class="widget-title"><span>',
         'after_title'   => '</span></h2>',
      )
   );

   $aster_storefront_footer_widget_column = get_theme_mod('aster_storefront_footer_widget_column', '4');
   for ($i = 1; $i <= $aster_storefront_footer_widget_column; $i++) {
      register_sidebar(array(
         'name' => __('Footer  ', 'aster-storefront')  . $i,
         'id' => 'aster-storefront-footer-widget-' . $i,
         'description' => __('The Footer Widget Area', 'aster-storefront')  . $i,
         'before_widget' => '<aside id="%1$s" class="widget %2$s">',
         'after_widget' => '</aside>',
         'before_title' => '<div class="widget-header"><h4 class="widget-title">',
         'after_title' => '</h4></div>',
      ));
   }
}
add_action('widgets_init', 'aster_storefront_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function aster_storefront_scripts()
{
   // Append .min if SCRIPT_DEBUG is false.
   $min = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

   // Slick style.
   wp_enqueue_style('aster-storefront-slick-style', get_template_directory_uri() . '/resource/css/slick' . $min . '.css', array(), '1.8.1');

   // Fontawesome style.
   wp_enqueue_style('aster-storefront-fontawesome-style', get_template_directory_uri() . '/resource/css/fontawesome' . $min . '.css', array(), '5.15.4');

   // Google fonts.
   wp_enqueue_style('aster-storefront-google-fonts', wptt_get_webfont_url(aster_storefront_get_fonts_url()), array(), null);

   // Main style.
   wp_enqueue_style('aster-storefront-style', get_template_directory_uri() . '/style.css', array(), ASTER_STOREFRONT_VERSION);

   // Navigation script.
   wp_enqueue_script('aster-storefront-navigation-script', get_template_directory_uri() . '/resource/js/navigation' . $min . '.js', array(), ASTER_STOREFRONT_VERSION, true);

   // Slick script.
   wp_enqueue_script('aster-storefront-slick-script', get_template_directory_uri() . '/resource/js/slick' . $min . '.js', array('jquery'), '1.8.1', true);

   // Custom script.
   wp_enqueue_script('aster-storefront-custom-script', get_template_directory_uri() . '/resource/js/custom' . $min . '.js', array('jquery'), ASTER_STOREFRONT_VERSION, true);

   if (is_singular() && comments_open() && get_option('thread_comments')) {
      wp_enqueue_script('comment-reply');
   }
}
add_action('wp_enqueue_scripts', 'aster_storefront_scripts');





// Enqueue Customizer live preview script
function aster_storefront_customizer_live_preview()
{
   wp_enqueue_script(
      'aster-storefront-customizer',
      get_template_directory_uri() . '/js/customizer.js',
      array('jquery', 'customize-preview'),
      '',
      true
   );
}
add_action('customize_preview_init', 'aster_storefront_customizer_live_preview');


// Output inline CSS based on Customizer setting
function aster_storefront_customizer_css()
{
   $enable_breadcrumb = get_theme_mod('aster_storefront_enable_breadcrumb', true);
?>
   <style type="text/css">
      <?php if (!$enable_breadcrumb) : ?>nav.woocommerce-breadcrumb {
         display: none;
      }

      <?php endif; ?>
   </style>
<?php
}
add_action('wp_head', 'aster_storefront_customizer_css');


function aster_storefront_customize_css()
{
?>
   <style type="text/css">
      :root {
         --primary-color: <?php echo esc_html(get_theme_mod('primary_color', '#FCF8F3')); ?>;
      }
   </style>
   <?php
}
add_action('wp_head', 'aster_storefront_customize_css');;
function enqueue_external_script()
{
   // Enqueue the external JavaScript file
   wp_enqueue_script('external-custom-js', site_url('/wp-content/product-custom.js'), array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_external_script');


function add_custom_script_in_footer()
{
   if (get_theme_mod('aster_storefront_enable_sticky_header', false)) {
   ?>
      <script>
         jQuery(document).ready(function($) {
            $(window).on('scroll', function() {
               var scroll = $(window).scrollTop();
               if (scroll > 0) {
                  $('.navigation-part.hello').addClass('is-sticky');
               } else {
                  $('.navigation-part.hello').removeClass('is-sticky');
               }
            });
         });
      </script>
   <?php
   }
}
add_action('wp_footer', 'add_custom_script_in_footer');


add_action('woocommerce_before_add_to_cart_button', 'display_product_options', 30);

function display_product_options()
{
   ?>
   <div class="template-customise">
      <div class="more-options" id="popup">
         <div class="more-custom" id="popupContent">
            <div class="closeBtn" id="closePopup">
               <i class="fas fa-times"></i>
            </div>
            <h3>Please select a design option</h3>
            <div class="browse-temps">
               <a href="javascript:void(0)" class="flex al-center" id="uploadMyDesign">
                  <div class="icon">
                     <i class="fas fa-upload"></i>
                  </div>
                  <div class="text">
                     <h4>Upload a completed design</h4>
                     <p>Upload a print ready file from your computer.</p>
                  </div>
               </a>
            </div>
         </div>
      </div>
      <div>
         <label for="">Personalise this product</label>
         <select name="customiseSelect" id="customiseSelect">
            <option value="No">No</option>
            <option value="Yes">Yes +$5</option>
         </select>
      </div>
      <div id="personaliseCover">
         <div class="accordion-toggle">
            <h4>Personalise Cover</h4>
         </div>
         <div class="accordion-content">
            <select name="personaliseProd" id="personaliseProd">
               <option value="Phrase">Phrase</option>
               <option value="Name or initial">Name or initial</option>
               <option value="Upload a logo">Upload a logo</option>
            </select>
            <input type="file" style="display:none;" />
            <span class="nameInitial">
               <textarea name="writingArea" maxlength="15" id="writingArea" rows="5" placeholder="Please enter the message"></textarea>
            </span>
            <div class="file" id="uploadImage">
               <label for="input-file" value="Upload a logo"> Select a file </label>
               <input type="file" id="logoUpload" />
            </div>
            <img id="logoPreview" src="" alt="Logo Preview" style="display:none; max-width: 200px; margin-top: 10px;" />
            <input type="hidden" id="logoDataUrl" name="logoDataUrl" />
            <div class="controls">
               <input name="textLine[]" type="text" id="textInput" maxlength="25" placeholder="Line 1" />
               <input name="textLine[]" type="text" id="textInput2" maxlength="25" placeholder="Line 2" />
               <input name="textLine[]" type="text" id="textInput3" maxlength="25" placeholder="Line 3" />
               <div style="display:none;">
                  <div class="controls_flex mr">
                     <div>
                        <label for="">Background shape name</label>
                        <select name="shapeSelect" id="shapeSelect">
                           <option value="rectangle">Rectangle</option>
                           <option value="square">Square</option>
                           <option value="circle">Circle</option>
                        </select>
                     </div>
                     <div>
                        <label for="">Text/Logo Position</label>
                        <select name="positionSelect" id="positionSelect">
                           <option value="left">Left</option>
                           <option value="right">Right</option>
                           <option value="middle">Middle</option>
                        </select>
                     </div>
                  </div>
                  <div>
                     <label for="fontSelect">Font:</label>
                     <select name="fontSelect" id="fontSelect">
                        <option value="Arial" selected>Arial</option>
                        <option value="Courier New">Courier New</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Verdana">Verdana</option>
                     </select>
                  </div>
                  <div class="controls_flex mr">
                     <div>
                        <label for="backgroundColor">Background Color:</label>
                        <input name="backgroundColor" type="color" id="backgroundColor" value="#FDF5F6">
                     </div>
                     <div>
                        <label for="textColor">Text Color:</label>
                        <input name="textColor" type="color" id="textColor" value="#000000">
                     </div>
                  </div>
               </div>
               <div class="more-cust">
                  <h4>Select background shape</h4>
                  <div class="swatch-container">
                     <div class="swatch customily-swatch">
                        <input id="rect1" name="shapeSelect" type="radio" value="rectangular" class="needsclick needsfocus">
                        <label for="rect1" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/10/55e6ac90-8ac2-4261-a67b-4e8fee0ba436.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="circle" name="shapeSelect" type="radio" value="circle" class="needsclick needsfocus">
                        <label for="circle" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/10/f02c6bba-314f-4f60-ac4f-1f082d3f5b03.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="trap" name="shapeSelect" type="radio" value="trap" class="needsclick needsfocus">
                        <label for="trap" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/10/7a3fb3b4-9b12-4a6a-9259-a71dac6c4f60.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="squr" name="shapeSelect" type="radio" value="square" class="needsclick needsfocus">
                        <label for="squr" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/10/92138a4f-da40-4bfe-8602-44a08f30c7b6.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                  </div>
               </div>
               <div class="more-cust">
                  <h4>Select font style</h4>
                  <div class="swatch-container">
                     <div class="swatch customily-swatch">
                        <input id="font1" type="radio" name="fontStyle" class="needsclick needsfocus">
                        <label for="font1" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/15fb2438-ceed-4cef-85e0-5d05506f687e.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="Grey_Qo" type="radio" name="fontStyle" value="Grey_Qo" class="needsclick needsfocus">
                        <label for="Grey_Qo" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/c79e1ed0-90cb-49f8-bbd8-33b410244058.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="Whisper" type="radio" name="fontStyle" value="Whisper" class="needsclick needsfocus">
                        <label for="Whisper" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/d5200861-5a05-495d-9878-41a847582e28.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="Cedarville" type="radio" name="fontStyle" value="Cedarville" class="needsclick needsfocus">
                        <label for="Cedarville" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/6aa6c070-f642-400f-bf30-7bc76c1355cf.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="roboto" type="radio" name="fontStyle" value="roboto" class="needsclick needsfocus">
                        <label for="roboto" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/51bba9cb-2e8b-45f9-ab39-b2f87e3e0a3c.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="noto" type="radio" name="fontStyle" value="noto" class="needsclick needsfocus">
                        <label for="noto" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/5481ad74-5b5a-4b1e-9aa1-5d9dab975abc.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="quitcher" type="radio" name="fontStyle" value="quitcher" class="needsclick needsfocus">
                        <label for="quitcher" class="needsclick needsfocus">
                           <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/3accc091-642e-4e90-b8d1-310b2333f3af.png"
                              loading="lazy" width="40" height="40">
                        </label>
                     </div>
                  </div>
               </div>
               <div class="more-cust-1">
                  <h4>Select background color</h4>
                  <div class="swatch-container">
                     <input type="hidden" id="backColor" value="#E7D9CD">
                     <div class="swatch customily-swatch">
                        <input id="black" type="radio" name="colorSelect" value="black" class="needsclick needsfocus" onclick="updateColor(`#000000`)">
                        <label for="black" class="needsclick needsfocus" style="background-color: #000000; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="white" type="radio" name="colorSelect" value="white" class="needsclick needsfocus" onclick="updateColor(`#ffffff`)">
                        <label for="white" class="needsclick needsfocus" style="background-color: #ffffff; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="grey" type="radio" name="colorSelect" value="grey" class="needsclick needsfocus" onclick="updateColor(`#b2b3b3`)">
                        <label for="grey" class="needsclick needsfocus" style="background-color: #b2b3b3; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="yellow" type="radio" name="colorSelect" value="yellow" class="needsclick needsfocus" onclick="updateColor(`#ead16a`)">
                        <label for="yellow" class="needsclick needsfocus" style="background-color: #ead16a; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="pink" type="radio" name="colorSelect" value="pink" class="needsclick needsfocus" onclick="updateColor(`#f6b9b1`)">
                        <label for="pink" class="needsclick needsfocus" style="background-color: #f6b9b1; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="orange" type="radio" name="colorSelect" value="orange" class="needsclick needsfocus" onclick="updateColor(`#e6843b`)">
                        <label for="orange" class="needsclick needsfocus" style="background-color: #e6843b; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input id="green" type="radio" name="colorSelect" value="green" class="needsclick needsfocus" onclick="updateColor(`#50744b`)">
                        <label for="green" class="needsclick needsfocus" style="background-color: #50744b; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                  </div>
               </div>
               <div class="more-cust-2">
                  <h4>Select text color</h4>
                  <div class="swatch-container">
                     <input type="hidden" id="textColor" value="#000000">
                     <div class="swatch customily-swatch">
                        <input onclick="updateTextColor(`#000000`)" id="tcblack" type="radio" name="textcolorSelect" value="black">
                        <label for="tcblack" style="background-color: #000000; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input onclick="updateTextColor(`#ffffff`)" id="tcwhite" type="radio" name="textcolorSelect" value="white">
                        <label for="tcwhite" style="background-color: #ffffff; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input onclick="updateTextColor(`#b2b3b3`)" id="tcgrey" type="radio" name="textcolorSelect" value="grey">
                        <label for="tcgrey" style="background-color: #b2b3b3; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input onclick="updateTextColor(`#ead16a`)" id="tcyellow" type="radio" name="textcolorSelect" value="yellow">
                        <label for="tcyellow" style="background-color: #ead16a; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input onclick="updateTextColor(`#f6b9b1`)" id="tcpink" type="radio" name="textcolorSelect" value="pink">
                        <label for="tcpink" style="background-color: #f6b9b1; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input onclick="updateTextColor(`#e6843b`)" id="tcorange" type="radio" name="textcolorSelect" value="orange">
                        <label for="tcorange" style="background-color: #e6843b; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                     <div class="swatch customily-swatch">
                        <input onclick="updateTextColor(`#50744b`)" id="tcgreen" type="radio" name="textcolorSelect" value="green">
                        <label for="tcgreen" style="background-color: #50744b; width: 40px; height: 40px; display: inline-block;"></label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div id="personaliseInner">
         <div class="accordion-toggle-inner">
            <h4>Personalise Inner Pages</h4>
         </div>
         <div class="accordion-content-inner">
            <div>
               <label for="">Select style</label>
               <select name="" id="pageSelection">
                  <option value="non">Select an option</option>
                  <option value="non">Cover</option>
                  <option value="Lined">Lined</option>
                  <option value="Non-Lined">Non-Lined</option>
               </select>
            </div>
            <div id="pagesCustom">
               <div class="logoText">
                  <label for="">Select an option</label>
                  <select name="innnerpages_selectionText" id="selectionText">
                     <option value="">Select an option</option>
                     <option value="uploadlogo">Upload a logo</option>
                     <option value="writetext">Write some text</option>
                  </select>
               </div>
               <div class="writeText">
                  <input type="text" placeholder="Write some text here" maxlength="20" id="insideWrite">
                  <div>
                     <label for="">Select position of text</label>
                     <select name="innerpages-textPosition" id="textPosition">
                        <option value="Top">Top</option>
                        <option value="Topleft">Top Left</option>
                        <option value="Topright">Top Right</option>
                        <option value="Bottom">Bottom</option>
                        <option value="Bottomleft">Bottom Left</option>
                        <option value="Bottomright">Bottom Right</option>
                        <option value="Top & Bottom">Top & Bottom</option>
                     </select>
                  </div>
                  <div class="more-cust">
                     <h4>Select font style</h4>
                     <div class="swatch-container">
                        <div class="swatch customily-swatch">
                           <input id="font1" type="radio" name="fontStyle" class="needsclick needsfocus">
                           <label for="font1" class="needsclick needsfocus">
                              <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/15fb2438-ceed-4cef-85e0-5d05506f687e.png"
                                 loading="lazy" width="40" height="40">
                           </label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input id="Grey_Qo" type="radio" name="fontStyle" value="Grey_Qo" class="needsclick needsfocus">
                           <label for="Grey_Qo" class="needsclick needsfocus">
                              <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/c79e1ed0-90cb-49f8-bbd8-33b410244058.png"
                                 loading="lazy" width="40" height="40">
                           </label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input id="Whisper" type="radio" name="fontStyle" value="Whisper" class="needsclick needsfocus">
                           <label for="Whisper" class="needsclick needsfocus">
                              <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/d5200861-5a05-495d-9878-41a847582e28.png"
                                 loading="lazy" width="40" height="40">
                           </label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input id="Cedarville" type="radio" name="fontStyle" value="Cedarville" class="needsclick needsfocus">
                           <label for="Cedarville" class="needsclick needsfocus">
                              <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/6aa6c070-f642-400f-bf30-7bc76c1355cf.png"
                                 loading="lazy" width="40" height="40">
                           </label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input id="roboto" type="radio" name="fontStyle" value="roboto" class="needsclick needsfocus">
                           <label for="roboto" class="needsclick needsfocus">
                              <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/51bba9cb-2e8b-45f9-ab39-b2f87e3e0a3c.png"
                                 loading="lazy" width="40" height="40">
                           </label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input id="noto" type="radio" name="fontStyle" value="noto" class="needsclick needsfocus">
                           <label for="noto" class="needsclick needsfocus">
                              <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/5481ad74-5b5a-4b1e-9aa1-5d9dab975abc.png"
                                 loading="lazy" width="40" height="40">
                           </label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input id="quitcher" type="radio" name="fontStyle" value="quitcher" class="needsclick needsfocus">
                           <label for="quitcher" class="needsclick needsfocus">
                              <img src="https://cdn.customily.com/shopify/assetFiles/swatches/may-designs-main.myshopify.com/af1a5c75-f3c9-474f-bc9d-590d16cae0d0/2/3accc091-642e-4e90-b8d1-310b2333f3af.png"
                                 loading="lazy" width="40" height="40">
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="more-cust-2">
                     <h4>Select text color</h4>
                     <div class="swatch-container">
                        <input type="hidden" id="textColor" value="#000000">
                        <div class="swatch customily-swatch">
                           <input onclick="updateTextColor(`#000000`)" id="tcblack" type="radio" name="textcolorSelect" value="black">
                           <label for="tcblack" style="background-color: #000000; width: 40px; height: 40px; display: inline-block;"></label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input onclick="updateTextColor(`#ffffff`)" id="tcwhite" type="radio" name="textcolorSelect" value="white">
                           <label for="tcwhite" style="background-color: #ffffff; width: 40px; height: 40px; display: inline-block;"></label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input onclick="updateTextColor(`#b2b3b3`)" id="tcgrey" type="radio" name="textcolorSelect" value="grey">
                           <label for="tcgrey" style="background-color: #b2b3b3; width: 40px; height: 40px; display: inline-block;"></label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input onclick="updateTextColor(`#ead16a`)" id="tcyellow" type="radio" name="textcolorSelect" value="yellow">
                           <label for="tcyellow" style="background-color: #ead16a; width: 40px; height: 40px; display: inline-block;"></label>
                        </div>

                        <div class="swatch customily-swatch">
                           <input onclick="updateTextColor(`#f6b9b1`)" id="tcpink" type="radio" name="textcolorSelect" value="pink">
                           <label for="tcpink" style="background-color: #f6b9b1; width: 40px; height: 40px; display: inline-block;"></label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input onclick="updateTextColor(`#e6843b`)" id="tcorange" type="radio" name="textcolorSelect" value="orange">
                           <label for="tcorange" style="background-color: #e6843b; width: 40px; height: 40px; display: inline-block;"></label>
                        </div>
                        <div class="swatch customily-swatch">
                           <input onclick="updateTextColor(`#50744b`)" id="tcgreen" type="radio" name="textcolorSelect" value="green">
                           <label for="tcgreen" style="background-color: #50744b; width: 40px; height: 40px; display: inline-block;"></label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="uploadInnerLogo">
               <div style="margin-bottom:15px;">
                  <h4>Upload a logo</h4>
                  <div class="file" id="uploadInnerLogo">
                     <label for="input-file" value="Upload a logo inner"> Select image </label>
                     <input type="file" id="logoUploadIn" />
                  </div>
               </div>
               <div>
                  <label for="">Select position of logo</label>
                  <select name="innerpages_logoPosition" id="logoPosition">
                     <option value="Top">Top</option>
                     <option value="Topleft">Top Left</option>
                     <option value="Topright">Top Right</option>
                     <option value="Bottom">Bottom</option>
                     <option value="Bottomleft">Bottom Left</option>
                     <option value="Bottomright">Bottom Right</option>
                     <option value="Top & Bottom">Top & Bottom</option>
                  </select>
               </div>
            </div>
            <div>
               <button id="popupOpen" type="button">More Customisations</button>
            </div>
            <div id="showUploadDesign">
               <div class="upload-design">
                  <div class="upload-top">
                     <h3>Upload your design</h3>
                  </div>
                  <div class="upload-bottom">
                     <div>
                        <label for="">Design Name</label>
                        <input type="text" name="innerpages_design_name" id="">
                     </div>
                     <div>
                        <label for="">Select Sheets, Size & Style</label>
                        <select name="innerpages_sheets_size" id="">
                           <option value="25">25 sheets per pad</option>
                           <option value="30">30 sheets per pad</option>
                        </select>
                     </div>
                     <div class="file" id="uploadImageInner">
                        <label for="input-file" value="Upload a logo">Upload Image</label>
                        <input type="file" id="logoUploadInner" />
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div>
      <input type="hidden" id="canvasData" name="canvasData" value="" />
      <img id="canvasPreview" style="display: block;width: 150px;height: 250px;margin-top: 10px;object-fit: cover;" />
      <input type="hidden" id="copiedImageUrl" name="copiedImageUrl" value="" />
   </div>
   <div class="save-btn">
      <button type="button" id="confirmChanges">Confirm Changes</button>
      <span id="loadingSpinner" style="display:none;">Loading...</span>
   </div>
   <script>
      document.getElementById('confirmChanges').addEventListener('click', function() {
         var canvasData = document.getElementById('canvasData').value;
      
         var xhr = new XMLHttpRequest();
         xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

         xhr.onload = function() {
            if (xhr.status === 200) {
               var response = JSON.parse(xhr.responseText);
               if (response.success) {
                  // Copy the saved image URL to clipboard
                  copyToClipboard(response.data.image_url);

                  // Store the image URL in the hidden input field
                  document.getElementById('copiedImageUrl').value = response.data.image_url;

                  // Optionally, add the saved image URL to the cart
                  addImageToCart(response.data.image_url);
               } else {
                  alert('An error occurred while saving the canvas data: ' + response.data.message);
               }
            } else {
               alert('An error occurred while saving the canvas data.');
            }
         };

         var data = 'action=save_canvas_data&canvas_data=' + encodeURIComponent(canvasData);
         xhr.send(data);
      });

      function copyToClipboard(text) {
         var tempInput = document.createElement('input');
         tempInput.value = text;
         document.body.appendChild(tempInput);
         tempInput.select();
         document.execCommand('copy');
         document.body.removeChild(tempInput);
         // alert('Image URL copied to clipboard: ' + text);
      }

      function addImageToCart(imageUrl) {
         var xhr = new XMLHttpRequest();
         xhr.open('POST', '<?php echo admin_url('admin-ajax.php'); ?>', true);
         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

         xhr.onload = function() {
            if (xhr.status === 200) {
               var response = JSON.parse(xhr.responseText);
               if (response.success) {
                  console.log('Image URL added to cart:', imageUrl);
               } else {
                  alert('An error occurred while adding the image to the cart.');
               }
            } else {
               alert('An error occurred while adding the image to the cart.');
            }
         };

         var data = 'action=add_image_to_cart&image_url=' + encodeURIComponent(imageUrl);
         xhr.send(data);
      }
   </script>
<?php


}

add_action('wp_ajax_save_canvas_data', 'save_canvas_data');
add_action('wp_ajax_nopriv_save_canvas_data', 'save_canvas_data');

function save_canvas_data()
{
   $response = array('success' => false);

   if (isset($_POST['canvas_data'])) {
      $canvas_data = $_POST['canvas_data'];
      $data = str_replace('data:image/png;base64,', '', $canvas_data);
      $data = base64_decode($data);

      // Define upload directory and file path
      $upload_dir = wp_upload_dir();
      $file_path = $upload_dir['path'] . '/personalization_image_' . uniqid() . '.png';

      // Save the image to the server
      file_put_contents($file_path, $data);

      // Return the URL of the saved image
      $image_url = $upload_dir['url'] . '/' . basename($file_path);

      // Save the image URL to session
      if (!session_id()) {
         session_start();
      }
      $_SESSION['personalization_image_url'] = $image_url;

      $response['success'] = true;
      $response['data'] = array('image_url' => $image_url);
   }

   wp_send_json($response);
}

add_action('wp_ajax_add_image_to_cart', 'add_image_to_cart');
add_action('wp_ajax_nopriv_add_image_to_cart', 'add_image_to_cart');

function add_image_to_cart()
{
   $response = array('success' => false);

   if (isset($_POST['image_url'])) {
      $image_url = esc_url_raw($_POST['image_url']);

      // Ensure session is started
      if (!session_id()) {
         session_start();
      }

      // Store the image URL in the session or a temporary storage mechanism
      $_SESSION['copied_image_url'] = $image_url;

      $response['success'] = true;
   }

   wp_send_json($response);
}


add_filter('woocommerce_add_cart_item_data', 'add_cart_item_data', 10, 2);

function add_cart_item_data($cart_item_data, $product_id)
{
   if (isset($_POST['customiseSelect']) && $_POST['customiseSelect'] === 'Yes') {
      $cart_item_data['personalization_price'] = 5; // $5 personalization fee
   }

   if (isset($_POST['writingArea']) && !empty($_POST['writingArea'])) {
      $cart_item_data['writing_area'] = sanitize_text_field($_POST['writingArea']);
   }

   if (isset($_POST['fontStyle']) && !empty($_POST['fontStyle'])) {
      $cart_item_data['font_style'] = sanitize_text_field($_POST['fontStyle']);
   }

   if (isset($_POST['personaliseProd']) && !empty($_POST['personaliseProd'])) {
      $cart_item_data['personalise_prod'] = sanitize_text_field($_POST['personaliseProd']);
   }

   if (isset($_POST['shapeSelect']) && !empty($_POST['shapeSelect'])) {
      $cart_item_data['shape_select'] = sanitize_text_field($_POST['shapeSelect']);
   }

   if (isset($_POST['fontSelect']) && !empty($_POST['fontSelect'])) {
      $cart_item_data['font_select'] = sanitize_text_field($_POST['fontSelect']);
   }

   if (isset($_POST['textLine']) && !empty($_POST['textLine'])) {
      $cart_item_data['text_Line'] = array_map('sanitize_text_field', $_POST['textLine']);
   }

   if (isset($_POST['colorSelect']) && !empty($_POST['colorSelect'])) {
      $cart_item_data['color_select'] = sanitize_text_field($_POST['colorSelect']);
   }

   if (isset($_POST['textcolorSelect']) && !empty($_POST['textcolorSelect'])) {
      $cart_item_data['text_color_select'] = sanitize_text_field($_POST['textcolorSelect']);
   }

   if (isset($_POST['innerpages-textPosition']) && !empty($_POST['innerpages-textPosition'])) {
      $cart_item_data['innerpages_text_position'] = sanitize_text_field($_POST['innerpages-textPosition']);
   }

   if (isset($_POST['innnerpages_selectionText']) && !empty($_POST['innnerpages_selectionText'])) {
      $cart_item_data['innnerpages_selection_text'] = sanitize_text_field($_POST['innnerpages_selectionText']);
   }

   if (isset($_POST['innerpages_pageSelection']) && !empty($_POST['innerpages_pageSelection'])) {
      $cart_item_data['innnerpages_pageSelection'] = sanitize_text_field($_POST['innerpages_pageSelection']);
   }

   if (isset($_POST['innerpages_fontStyle']) && !empty($_POST['innerpages_fontStyle'])) {
      $cart_item_data['innnerpages_font_Style'] = sanitize_text_field($_POST['innerpages_fontStyle']);
   }

   if (isset($_POST['innerpages_textcolorSelect']) && !empty($_POST['innerpages_textcolorSelect'])) {
      $cart_item_data['innnerpages_textcolor_Select'] = sanitize_text_field($_POST['innerpages_textcolorSelect']);
   }

   if (isset($_POST['innerpages_logoPosition']) && !empty($_POST['innerpages_logoPosition'])) {
      $cart_item_data['innnerpages_logo_Position'] = sanitize_text_field($_POST['innerpages_logoPosition']);
   }

   if (isset($_POST['innerpages_design_name']) && !empty($_POST['innerpages_design_name'])) {
      $cart_item_data['innnerpages_designname'] = sanitize_text_field($_POST['innerpages_design_name']);
   }

   if (isset($_POST['innerpages_sheets_size']) && !empty($_POST['innerpages_sheets_size'])) {
      $cart_item_data['innnerpages_sheetssize'] = sanitize_text_field($_POST['innerpages_sheets_size']);
   }

   if (isset($_POST['copiedImageUrl']) && !empty($_POST['copiedImageUrl'])) {
      $cart_item_data['copied_Image_Url'] = sanitize_text_field($_POST['copiedImageUrl']);
   }

   if (isset($_POST['logoDataUrl']) && !empty($_POST['logoDataUrl'])) {
      $logo_img = $_POST['logoDataUrl'];

      // Check and determine the extension from the base64 string
      if (strpos($logo_img, 'data:image/png') === 0) {
         $extension = '.png';
      } elseif (strpos($logo_img, 'data:image/jpeg') === 0) {
         $extension = '.jpg';
      } elseif (strpos($logo_img, 'data:image/jpg') === 0) {
         $extension = '.jpg';
      } elseif (strpos($logo_img, 'data:image/gif') === 0) {
         $extension = '.gif';
      } else {
         return $cart_item_data;
      }

      // Remove the data URL scheme part
      $data = preg_replace('#^data:image/\w+;base64,#i', '', $logo_img);
      $data = base64_decode($data);

      // Define upload directory and file path with the correct extension
      $upload_dir = wp_upload_dir();
      $file_name = 'logo_image_' . uniqid() . $extension;
      $file_path = $upload_dir['path'] . '/' . $file_name;

      // Save the image to the server
      file_put_contents($file_path, $data);

      // Get the URL of the saved image
      $image_url = $upload_dir['url'] . '/' . $file_name;

      // Store the image URL in the cart item data
      $cart_item_data["logoDataUrl"] = $image_url;
   }

   if (isset($_POST['canvasData'])) {
      $canvas_data = $_POST['canvasData'];

      // Remove the data URL scheme part (data:image/png;base64,)
      $data = str_replace('data:image/png;base64,', '', $canvas_data);
      $data = base64_decode($data);

      // Define upload directory and file path
      $upload_dir = wp_upload_dir();
      $file_path = $upload_dir['path'] . '/canvas_image_' . uniqid() . '.png';

      // Save the image to the server
      file_put_contents($file_path, $data);

      // Return the URL of the saved image
      $image_url = $upload_dir['url'] . '/' . basename($file_path);

      $cart_item_data["canvasData"] = $image_url;
   }

   return $cart_item_data;
}

// Add canvas data to cart item

add_action('woocommerce_before_calculate_totals', 'update_personalization_price');

function update_personalization_price($cart)
{
   if (is_admin() && !defined('DOING_AJAX')) return;

   foreach ($cart->get_cart() as $cart_item) {
      if (isset($cart_item['personalization_price'])) {
         $cart_item['data']->set_price($cart_item['data']->get_price() + $cart_item['personalization_price']);
      }
   }
}

add_filter('woocommerce_get_item_data', 'display_image_data_in_cart', 10, 2);

function display_image_data_in_cart($item_data, $cart_item)
{
   if (isset($cart_item['personalization_price'])) {
      $item_data[] = array(
         'key'   => __('Personalization', 'woocommerce'),
         'value' => __('Yes', 'woocommerce') . ' (+$5)',
      );
   }

   if (isset($cart_item['writing_area'])) {
      $item_data[] = array(
         'name' => __('Personalized Message', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['writing_area']),
      );
   }

   if (isset($cart_item['font_style'])) {
      $item_data[] = array(
         'name' => __('Font Style', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['font_style']),
      );
   }

   if (isset($cart_item['personalise_prod'])) {
      $item_data[] = array(
         'name' => __('Personalization Type', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['personalise_prod']),
      );
   }

   if (isset($cart_item['shape_select'])) {
      $item_data[] = array(
         'name' => __('Shape', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['shape_select']),
      );
   }

   if (isset($cart_item['font_select'])) {
      $item_data[] = array(
         'name' => __('Font', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['font_select']),
      );
   }

   if (isset($cart_item['text_Line']) && !empty($cart_item['text_Line'])) {
      foreach ($cart_item['text_Line'] as $index => $line) {
         $item_data[] = array(
            'name' => sprintf(__('Custom Text Line %d', 'woocommerce'), $index + 1),
            'value' => esc_html($line),
         );
      }
   }

   if (isset($cart_item['text_color_select'])) {
      $item_data[] = array(
         'name' => __('Text Color', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['text_color_select']),
      );
   }

   if (isset($cart_item['color_select'])) {
      $item_data[] = array(
         'name' => __('Color', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['color_select']),
      );
   }

   if (isset($cart_item['innerpages_text_position'])) {
      $item_data[] = array(
         'name' => __('Text Position', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['innerpages_text_position']),
      );
   }

   if (isset($cart_item['innnerpages_selection_text'])) {
      $item_data[] = array(
         'name' => __('Selection Text', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['innnerpages_selection_text']),
      );
   }

   if (isset($cart_item['innnerpages_pageSelection'])) {
      $item_data[] = array(
         'name' => __('Page Selection', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['innnerpages_pageSelection']),
      );
   }

   if (isset($cart_item['innnerpages_font_Style'])) {
      $item_data[] = array(
         'name' => __('Font Style', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['innnerpages_font_Style']),
      );
   }

   if (isset($cart_item['innnerpages_textcolor_Select'])) {
      $item_data[] = array(
         'name' => __('Text Color', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['innnerpages_textcolor_Select']),
      );
   }

   if (isset($cart_item['innnerpages_logo_Position'])) {
      $item_data[] = array(
         'name' => __('Logo Position', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['innnerpages_logo_Position']),
      );
   }

   if (isset($cart_item['innnerpages_designname'])) {
      $item_data[] = array(
         'name' => __('Design Name', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['innnerpages_designname']),
      );
   }

   if (isset($cart_item['innnerpages_sheetssize'])) {
      $item_data[] = array(
         'name' => __('Sheets Size', 'woocommerce'),
         'value' => sanitize_text_field($cart_item['innnerpages_sheetssize']),
      );
   }

   if (isset($cart_item['logoDataUrl'])) {
      $item_data[] = array(
         'name' => __('Uploaded Logo', 'woocommerce'),
         'value' => sprintf(
            '<img src="%s" style="width: 100px; height: auto;">',
            esc_url($cart_item['logoDataUrl'])
         ),
      );
   }

   if (isset($cart_item['canvasData'])) {
      $item_data[] = array(
         'name' => __('Inner Page ', 'woocommerce'),
         'value' => esc_url($cart_item['canvasData']), // Display the URL only
      );
   }
   if (isset($cart_item['copied_Image_Url'])) {
      $item_data[] = array(
         'name' => __('Cover Page', 'woocommerce'),
         'value' => esc_url($cart_item['copied_Image_Url']), // Display the URL only
      );
   }

   return $item_data;
}

add_action('woocommerce_checkout_create_order_line_item', 'save_personalization_data_to_order', 10, 4);

function save_personalization_data_to_order($item, $cart_item_key, $values, $order)
{
   if (isset($values['personalization_price'])) {
      $item->add_meta_data(__('Personalization Fee', 'woocommerce'), wc_price($values['personalization_price']));
   }

   if (isset($values['writing_area'])) {
      $item->add_meta_data(__('Personalized Message', 'woocommerce'), sanitize_text_field($values['writing_area']));
   }

   if (isset($values['font_style'])) {
      $item->add_meta_data(__('Font Style', 'woocommerce'), sanitize_text_field($values['font_style']));
   }

   if (isset($values['personalise_prod'])) {
      $item->add_meta_data(__('Personalization Type', 'woocommerce'), sanitize_text_field($values['personalise_prod']));
   }

   if (isset($values['shape_select'])) {
      $item->add_meta_data(__('Shape', 'woocommerce'), sanitize_text_field($values['shape_select']));
   }

   if (isset($values['font_select'])) {
      $item->add_meta_data(__('Font', 'woocommerce'), sanitize_text_field($values['font_select']));
   }

   if (isset($values['text_Line'])) {
      foreach ($values['text_Line'] as $index => $line) {
         $item->add_meta_data(sprintf(__('Custom Text Line %d', 'woocommerce'), $index + 1), esc_html($line));
      }
   }

   if (isset($values['text_color_select'])) {
      $item->add_meta_data(__('Text Color', 'woocommerce'), sanitize_text_field($values['text_color_select']));
   }

   if (isset($values['color_select'])) {
      $item->add_meta_data(__('Color', 'woocommerce'), sanitize_text_field($values['color_select']));
   }

   if (isset($values['innerpages_text_position'])) {
      $item->add_meta_data(__('Text Position', 'woocommerce'), sanitize_text_field($values['innerpages_text_position']));
   }

   if (isset($values['innnerpages_selection_text'])) {
      $item->add_meta_data(__('Selection Text', 'woocommerce'), sanitize_text_field($values['innnerpages_selection_text']));
   }

   if (isset($values['innnerpages_pageSelection'])) {
      $item->add_meta_data(__('Page Selection', 'woocommerce'), sanitize_text_field($values['innnerpages_pageSelection']));
   }

   if (isset($values['innnerpages_font_Style'])) {
      $item->add_meta_data(__('Font Style', 'woocommerce'), sanitize_text_field($values['innnerpages_font_Style']));
   }

   if (isset($values['innnerpages_textcolor_Select'])) {
      $item->add_meta_data(__('Text Color', 'woocommerce'), sanitize_text_field($values['innnerpages_textcolor_Select']));
   }

   if (isset($values['innnerpages_logo_Position'])) {
      $item->add_meta_data(__('Logo Position', 'woocommerce'), sanitize_text_field($values['innnerpages_logo_Position']));
   }

   if (isset($values['innnerpages_designname'])) {
      $item->add_meta_data(__('Design Name', 'woocommerce'), sanitize_text_field($values['innnerpages_designname']));
   }

   if (isset($values['innnerpages_sheetssize'])) {
      $item->add_meta_data(__('Sheets Size', 'woocommerce'), sanitize_text_field($values['innnerpages_sheetssize']));
   }

   if (isset($values['logoDataUrl'])) {
      $item->add_meta_data(__('Uploaded Logo', 'woocommerce'), esc_url($values['logoDataUrl']));
   }

   if (isset($values['canvasData'])) {
      $item->add_meta_data(__('Inner Page', 'woocommerce'), esc_url($values['canvasData']));
   }

   if (isset($values['copied_Image_Url'])) {
      $item->add_meta_data(__('Cover Page', 'woocommerce'), esc_url($values['copied_Image_Url']));
   }
}

// Display the Personalization Image in the order details (admin and customer emails)
add_action('woocommerce_order_item_meta_end', 'display_canvas_data_in_order', 10, 3);
function display_canvas_data_in_order($item_id, $item, $order)
{
   $item_meta = $item->get_meta(__('Personalization Image', 'your-textdomain'));
   if ($item_meta) {
      // Display the image and the URL
      echo '<p><strong>' . __('Personalization Image', 'your-textdomain') . ':</strong> 
            <img src="' . esc_url($item_meta) . '" style="width: 100px; height: auto; margin-top: 10px;"></p>';
   }
}

// Display the canvas image in the WooCommerce admin order details
add_action('woocommerce_admin_order_item_headers', 'display_canvas_data_in_order_admin', 10, 1);
function display_canvas_data_in_order_admin($order)
{
   foreach ($order->get_items() as $item_id => $item) {
      $personalization_image = $item->get_meta(__('Personalization Image', 'your-textdomain'));
      $uploaded_logo = $item->get_meta(__('Uploaded Logo', 'woocommerce'));

      if ($personalization_image) {
         echo '<p><strong>' . __('Personalization Image', 'your-textdomain') . ':</strong><br>';
         echo '<img src="' . esc_url($personalization_image) . '" alt="' . __('Personalization Image', 'your-textdomain') . '" style="max-width: 150px; height: auto; margin-top: 10px;">';
         echo '</p>';
      }

      if ($uploaded_logo) {
         echo '<p><strong>' . __('Uploaded Logo', 'woocommerce') . ':</strong><br>';
         echo '<img src="' . esc_url($uploaded_logo) . '" alt="' . __('Uploaded Logo', 'woocommerce') . '" style="max-width: 150px; height: auto; margin-top: 10px;">';
         echo '</p>';
      }

      // Add more fields as needed
      if ($personalization_price = $item->get_meta(__('Personalization Price', 'woocommerce'))) {
         echo '<p><strong>' . __('Personalization Price', 'woocommerce') . ':</strong> ' . wc_price($personalization_price) . '</p>';
      }
      if ($writing_area = $item->get_meta(__('Personalized Message', 'woocommerce'))) {
         echo '<p><strong>' . __('Personalized Message', 'woocommerce') . ':</strong> ' . esc_html($writing_area) . '</p>';
      }
   }
}

<?php
/*
Plugin Name: Admin 1995
Plugin URI: https://www.digital.ink
Description: Wordpress Admin Theme by Felix Buhler
Author: Felix Buhler
Version: 1.0
Author URI: https://www.digital.ink
*/

function my_admin_theme_style()
{
    wp_enqueue_style('my-admin-theme', plugins_url('/admin.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'my_admin_theme_style');

// Remove Icons
function sertmedia_remove_dashicons_junk()
{
    if (is_user_logged_in()) {
        wp_dequeue_style('dashicons');
    }
}
add_action('wp_enqueue_scripts', 'sertmedia_remove_dashicons_junk');

// Customizer Additions

function theme_colors_customizer($wp_customize)
{

    // Add New Section: Background Colors
    $wp_customize->add_section(
        'theme_color_section',
        array(
            'title' => '1995 Theme Colors',
            'description' => 'Set Theme Colors',
            'priority' => '40'
        )
    );

    // Main Color
    $wp_customize->add_setting(
        'theme_main_color',
        array(
            'default' => '#0000ff',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'theme_main_color',
            array(
                'label' => 'Choose Main Color',
                'section' => 'theme_color_section',
                'description' => ('The main color'),
                'settings' => 'theme_main_color'
            )
        )
    );

    // Black
    $wp_customize->add_setting(
        'theme_black_color',
        array(
            'default' => '#262626',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'theme_black_color',
            array(
                'label' => 'Choose Black',
                'section' => 'theme_color_section',
                'description' => ('Should be something very dark'),
                'settings' => 'theme_black_color'
            )
        )
    );

    // White
    $wp_customize->add_setting(
        'theme_white_color',
        array(
            'default' => '#ffffff',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'theme_white_color',
            array(
                'label' => 'Choose White',
                'section' => 'theme_color_section',
                'description' => ('Should be really light'),
                'settings' => 'theme_white_color'
            )
        )
    );

    // Notification
    $wp_customize->add_setting(
        'theme_notification_color',
        array(
            'default' => '#ff4d00',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'theme_notification_color',
            array(
                'label' => 'Choose Notification Color',
                'section' => 'theme_color_section',
                'description' => ('Maybe red?'),
                'settings' => 'theme_notification_color'
            )
        )
    );

    // Button Hover
    $wp_customize->add_setting(
        'theme_button_hover_color',
        array(
            'default' => '#5959ff',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'theme_button_hover_color',
            array(
                'label' => 'Choose Button:hover Color',
                'section' => 'theme_color_section',
                'description' => ('Something lighter than the main color'),
                'settings' => 'theme_button_hover_color'
            )
        )
    );
}

add_action('customize_register', 'theme_colors_customizer');

// Custom Colors
function theme_colors_css()
{

    $colorMain = get_theme_mod('theme_main_color');
    $colorBlack = get_theme_mod('theme_black_color');
    $colorWhite = get_theme_mod('theme_white_color');
    $colorNotification = get_theme_mod('theme_notification_color');
    $colorButtonHover = get_theme_mod('theme_button_hover_color');

    ?>
    <style id="custom-colors">
        :root {
            /* Brand Colors */
            --color-main:
                <?php echo esc_html($colorMain); ?>
            ;
            --color-black:
                <?php echo esc_html($colorBlack); ?>
            ;
            --color-white:
                <?php echo esc_html($colorWhite); ?>
            ;
            --color-notification:
                <?php echo esc_html($colorNotification); ?>
            ;
            --color-button-hover:
                <?php echo esc_html($colorButtonHover); ?>
            ;

            /* UI Colors */

            /* Padding */

        }
    </style>
    <script>
        jQuery(document).ready(function ($) {
            $.wp.wpColorPicker.prototype.options = {
                hide: true,
                palettes: ['#262626', '#0059ff', '#ff4d00', '#00ff00', '#FF61C8', '#fbdd74']
            };
        });
    </script>

    <?php
}

add_action('admin_head', 'theme_colors_css');
add_action('customize_controls_head', 'theme_colors_css');
add_action('login_head', 'theme_colors_css');

// Custom Admin Pallette

add_action('admin_init', function () {

    $colorMain = get_theme_mod('theme_main_color');
    $colorBlack = get_theme_mod('theme_black_color');
    $colorWhite = get_theme_mod('theme_white_color');
    $colorNotification = get_theme_mod('theme_notification_color');
    $colorButtonHover = get_theme_mod('theme_button_hover_color');

    wp_admin_css_color(
        '1995',
        __('1995'),
        admin_url("css/colors-classic.css"),
        array(
            $colorMain,
            $colorButtonHover,
            $colorNotification,
            $colorBlack
        )
    );
});

function admin_color_scheme()
{
    global $_wp_admin_css_colors;
    $_wp_admin_css_colors = 0;
}
add_action('admin_head', 'admin_color_scheme');

// Login 

function login_stylesheet()
{
    wp_enqueue_style('custom-login', plugins_url('/admin.css', __FILE__));
    wp_enqueue_script('custom-login', get_stylesheet_directory_uri() . '/style-login.js');
}
add_action('login_enqueue_scripts', 'login_stylesheet');

add_theme_support('custom-logo');
function theme_logo()
{ ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url(<?php echo esc_url(wp_get_attachment_url(get_theme_mod('custom_logo'))); ?>);
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'theme_logo');

function login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'login_logo_url');

function login_logo_url_title()
{
    return get_bloginfo('name');
}
add_filter('login_headertitle', 'login_logo_url_title');

?>
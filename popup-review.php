<?php
/*
    Plugin Name: Popup Notification
    Description: Notification Popup Plugin
    Version: 1.0.0
    Text Domain: notification-popup
    Author: Sayed Nur E Newaz
    Domain Path: /languages

*/

// Scripts and CSS
function enqueue_scripts()
{
    // Enqueue custom CSS file
    wp_enqueue_style('custom-css', plugin_dir_url(__FILE__) . 'assets/css/popupPlugin.css');

    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0', 'all');

    // Enqueue Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600&display=swap');

    // Enqueue Bootstrap JavaScript
    wp_enqueue_script('bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array(), '5.0.2', true);

    // Enqueue custom JavaScript file
    wp_enqueue_script('custom-js', plugin_dir_url(__FILE__) . 'assets/js/popupPlugin.js', array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'enqueue_scripts');

// Register the popup post type
function custom_register_popup_post_type() {
    register_post_type( 'popup', array(
        'labels' => array(
            'name' => 'Popups',
            'singular_name' => 'Popup'
        ),
        'public' => true,
        'has_archive' => false,
        'supports' => array( 'title', 'editor' ),
    ) );
}
add_action( 'init', 'custom_register_popup_post_type' );

// Display the popup on the front end
function custom_display_popup() {
    $args = array(
        'post_type' => 'popup',
        'posts_per_page' => 1,
        'orderby' => 'rand',
    );
    $popups = new WP_Query( $args );

    if ( $popups->have_posts() ) {
        while ( $popups->have_posts() ) {
            $popups->the_post();
            $popup_id = get_the_ID();

            // Get the custom field values
            $name = get_field('name');
            $location = get_field('location');
            $stars = get_field('stars');
            $content = get_field('content');
            $link = get_field('link');
            $product_name = get_field('product_name');
            $image = get_field('product_image');

            // Customize the popup view
                echo '<div class="popup-modal">'; 
                    echo '<div class="left">';
                        echo '<a href=" ' . $link . ' " target="_blank">';
                        // Image Here
                        if ($image) {
                            echo '<img class="popup-image" src="' . $image['url'] . '" alt="' . $image['alt'] . '">';
                        }
                        echo '</a>';
                    echo '</div>';
                    echo '<div class="right">';
                        echo '<div class="popup-content">';
                        echo '<span class="close-button">&times;</span>'; 
                            echo '<div style="width:95%">';
                                echo '<span class="popup-content-font-size">
                                    <b>' . $name .  '</b>' . ' from  <b>' .$location. '</b> left a review';
                                    echo '<span class="star-icons-margin">';
                                    for ($i = 0; $i < $stars; $i++) {
                                        echo '<span class="star-icon" style="color:#FDF751">&#9733;</span></span>';
                                    }        
                                echo '</span>';
                                echo '<p class="popup-review">' . $content . '</p>';                                
                            echo '</div>';
                        echo '</div>';                
                    echo '</div>';                
                echo '</div>';

            

            // echo '<a href="' . $link . '"></a>';
            // Mark the popup as displayed
            update_post_meta( $popup_id, 'displayed', true );
        }
    }
    wp_reset_postdata();
}
add_action( 'wp_footer', 'custom_display_popup' );

// Schedule the popup display
// Enqueue custom JavaScript file and pass ajaxurl
function custom_schedule_popup() {
    $popup_delay = 20000; 
    $popup_interval = 60000; 

    wp_enqueue_script( 'custom-script', plugin_dir_url( __FILE__ ) . 'assets/js/popupPlugin.js', array( 'jquery' ), '1.0', true );
    wp_localize_script( 'custom-script', 'custom_ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

    wp_add_inline_script( 'custom-script', '
        jQuery(function($) {
            function showPopup() {
                $(".popup").fadeIn(300); 
            }

            function hidePopup() {
                $(".popup").fadeOut(300); 
            }

            // Show the initial popup after the delay
            setTimeout(showPopup, ' . $popup_delay . ');

            // Schedule subsequent popups at intervals
            setInterval(function() {
                showPopup();
                setTimeout(hidePopup, ' . $popup_delay . ');
            }, ' . $popup_interval . ');
        });
    ' );
}
add_action( 'wp_enqueue_scripts', 'custom_schedule_popup' );


// AJAX callback to display the popup
function custom_ajax_display_popup() {
    ob_start();
    custom_display_popup();
    $popup_content = ob_get_clean();
    echo $popup_content;
    wp_die();
}
add_action( 'wp_ajax_custom_display_popup', 'custom_ajax_display_popup' );
add_action( 'wp_ajax_nopriv_custom_display_popup', 'custom_ajax_display_popup' );
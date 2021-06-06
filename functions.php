<?php

add_action('init', function () {
    remove_action('storefront_header', 'storefront_product_search', 40);
    remove_action( 'storefront_header', 'storefront_site_branding', 20 );
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
    remove_action( 'storefront_footer', 'storefront_handheld_footer_bar', 999 );
}, 10, 0);


add_filter('theme_mod_custom_logo', function () {
    return true;
}, 10, 0);


add_action('storefront_header', function () {
    $tag = is_home() ? 'h1' : 'div';

    $html = '<' . esc_attr($tag) . '><a href="' . esc_url( home_url( '/' ) ) . '" rel="home"><img src="' . get_stylesheet_directory_uri() . '/images/logo.svg" alt="' . esc_attr(get_bloginfo( 'name' )) . ' logo" class="site-logo"></a></' . esc_attr($tag) . '>';

    if ( '' !== get_bloginfo( 'description' ) ) {
        $html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
    }
    echo $html;
}, 20, 0);


add_filter('storefront_copyright_text', function () { return ''; }, 10, 0);


add_filter('storefront_credit_links_output', function () {
    return '&copy; stadtnavi ' . gmdate( 'Y' ) . ' | <a href="/datenschutz">Datenschutz</a> | <a href="/impressum">Impressum</a>';
}, 10, 0);


add_filter('body_class', function($classes) {
    if (!is_page() || is_front_page())
        return $classes;
    global $post;
    $classes[] = 'post-slug-' . $post->post_name;
    return $classes;
});


/*
 * removes woocommerce marketing feature
 */
add_filter( 'woocommerce_admin_features', function(array $features): array {
    $marketing = array_search('marketing', $features);
    unset( $features[$marketing] );
    return $features;
});


add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' );
add_filter( 'woocommerce_admin_disabled', '__return_true' );


/*
 * removes woocommerce dashboard meta box
 */
add_action('wp_dashboard_setup', function () {
    remove_meta_box('woocommerce_dashboard_status', 'dashboard', 'normal');
});


/*
 * removes notices
 */
add_action('wp_loaded', function () {
    remove_action('admin_notices', 'vendidero_helper_notice');
    remove_action('admin_notices', 'woothemes_updater_notice');
});

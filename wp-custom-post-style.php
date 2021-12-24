<?php
/**
 * Plugin Name:       WP Custom Post Style
 * Plugin URI:        #
 * Description:       Provides Custom Post Style
 * Author:            Team Techvengers
 * Author URI:        https://techvengers.com
 * Text Domain:       wp-custom-post-style
 */

$new_page_content = '<div id="content" class="clearfix row">
			
<div id="main" class="col-sm-8 clearfix" role="main">

    <div class="page-header">
    <?php if (is_category()) { ?>
        <h1 class="archive_title h2">
            <span><?php _e("Posts Categorized:", "wpbootstrap"); ?></span> <?php single_cat_title(); ?>
        </h1>
    <?php } elseif (is_tag()) { ?> 
        <h1 class="archive_title h2">
            <span><?php _e("Posts Tagged:", "wpbootstrap"); ?></span> <?php single_tag_title(); ?>
        </h1>
    <?php } elseif (is_author()) { ?>
        <h1 class="archive_title h2">
            <span><?php _e("Posts By:", "wpbootstrap"); ?></span> <?php get_the_author_meta("display_nam"); ?>
        </h1>
    <?php } elseif (is_day()) { ?>
        <h1 class="archive_title h2">
            <span><?php _e("Daily Archives:", "wpbootstrap"); ?></span> <?php the_time("l, F j, Y"); ?>
        </h1>
    <?php } elseif (is_month()) { ?>
        <h1 class="archive_title h2">
            <span><?php _e("Monthly Archives:", "wpbootstrap"); ?></span> <?php the_time("F Y"); ?>
        </h1>
    <?php } elseif (is_year()) { ?>
        <h1 class="archive_title h2">
            <span><?php _e("Yearly Archives:", "wpbootstrap"); ?></span> <?php the_time("Y"); ?>
        </h1>
    <?php } ?>
    </div>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class("clearfix"); ?> role="article">
        
        <header>
            
            <h3 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
            
            <p class="meta"><?php _e("Posted", "wpbootstrap"); ?> <time datetime="<?php echo the_time("Y-m-j"); ?>" pubdate><?php the_time(); ?></time> <?php _e("by", "wpbootstrap"); ?> <?php the_author_posts_link(); ?> <span class="amp">&</span> <?php _e("filed under", "wpbootstrap"); ?> <?php the_category(', '); ?>.</p>
        
        </header> <!-- end article header -->
    
        <section class="post_content">
        
            <?php the_post_thumbnail( "wpbs-featured" ); ?>
        
            <?php the_excerpt(); ?>
    
        </section> <!-- end article section -->
        
        <footer>
            
        </footer> <!-- end article footer -->
    
    </article> <!-- end article -->
    
    <?php endwhile; ?>	
    
    <?php if (function_exists("wp_bootstrap_page_navi")) { // if expirimental feature is active ?>
        
        <?php wp_bootstrap_page_navi(); // use the page navi function ?>

    <?php } else { // if it is disabled, display regular wp prev & next links ?>
        <nav class="wp-prev-next">
            <ul class="pager">
                <li class="previous"><?php next_posts_link(_e("&laquo; Older Entries", "wpbootstrap")) ?></li>
                <li class="next"><?php previous_posts_link(_e("Newer Entries &raquo;", "wpbootstrap")) ?></li>
            </ul>
        </nav>
    <?php } ?>
                
    
    <?php else : ?>
    
    <article id="post-not-found">
        <header>
            <h1><?php _e("No Posts Yet", "wpbootstrap"); ?></h1>
        </header>
        <section class="post_content">
            <p><?php _e("Sorry, What you were looking for is not here.", "wpbootstrap"); ?></p>
        </section>
        <footer>
        </footer>
    </article>
    
    <?php endif; ?>

</div> <!-- end #main -->

<?php get_sidebar(); // sidebar 1 ?>

</div> <!-- end #content -->';

function add_my_custom_page() {
    // Create post object
    $my_post = array(
      'post_title'    => wp_strip_all_tags( 'My Custom Page' ),
      'post_content'  => $new_page_content,
      'post_status'   => 'publish',
      'post_type'     => 'page',
    );
    wp_insert_post( $my_post );
}

register_activation_hook(__FILE__, 'add_my_custom_page');

function on_deactivating_your_plugin() {

    $page = get_page_by_path( 'My Custom Page' );
    wp_delete_post($page->ID);

}
register_deactivation_hook( __FILE__, 'on_deactivating_your_plugin' );
// Register Post Type
function pluginprefix_setup_post_type() {
    register_post_type( 'book', ['public' => true ] ); 
} 
add_action( 'init', 'pluginprefix_setup_post_type' );
// Plugin Activation
function wp_custom_post_style_activate() {
    pluginprefix_setup_post_type();
    flush_rewrite_rules(); 
}
register_activation_hook( 'wp-custom-post-style', 'wp_custom_post_style_activate' );
// Plugin Deactivation
function wp_custom_post_style_deactivate() {
    unregister_post_type( 'book' );
    flush_rewrite_rules();
}
register_deactivation_hook( 'wp-custom-post-style', 'wp_custom_post_style_deactivate' );
<?php
/**
 * Plugin Name: MyCludo CMS Plugin
 * Plugin URI: http://www.cludo.com/
 * Description: Add cludo cms script to wp-admin
 * Version: 1.0.0
 * Author: Josh Bruflodt
 * Author URI: http://www.cludo.com
 */



 
// ===
// ADD THE OVERLAY SCRIPT TO THE SITE
// ===
function my_script($hook) {
    wp_enqueue_script('my_custom_script', 'https://customer.cludo.com/scripts/cludo-cms-overlay/1.0.0/cludo-cms-overlay.min.js', array(), '1.0.0', true);
}

add_action('admin_enqueue_scripts', 'my_script');




// ===
// ADD THE INLINE JS THAT INSTANTIATES THE CLUDO OBJECT AND ADDS CMS EVENT
// ===
function cludo_event_queue() {
    global $wp_version;
?>
    <script type="text/javascript">
        // Instantiate the array if we don't have a cludo object already
        var _cludo = window._cludo || [];

        // Push the cms event to the event array
        _cludo.push(
            {
                event: 'cms',
                data: {
                    platform: 'WordPress',
                    version: '<?php echo $wp_version ?>'
                }
            });
<?php
    // ===
    // ADD PAGE CONTEXT EVENT IF APPLICABLE
    // ===
    global $post;
    if (isset($post) && isset($post->ID)) {
        $url = get_permalink($post->ID);
?>
        // Push the setPage event to the event array
        _cludo.push(
            {
                event: 'setPage',
                data: {
                    url: '<?php echo $url ?>'
                }
            });

<?php
    }
?>
    </script>;
<?php
}

add_action( 'admin_head', 'cludo_event_queue' );

?>
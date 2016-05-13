<?php
/*
Plugin Name: Post Expiration Date
Plugin URI: http://harrisonmcguire.com/
Description: Adds an expiration date to posts, using a the jQuery UI datepicker
Author: Harrison McGuire
Version: 1.0
 */

function tutsplus_load_jquery_datepicker() {    
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_style( 'jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css' );
}
add_action( 'admin_enqueue_scripts', 'tutsplus_load_jquery_datepicker' );

function tutsplus_add_expiry_date_metabox() {
    add_meta_box( 
        'tutsplus_expiry_date_metabox', 
        __( 'Expiry Date', 'tutsplus'), 
        'tutsplus_expiry_date_metabox_callback', 
        'post', 
        'side', 
        'high'
    );
}
add_action( 'add_meta_boxes', 'tutsplus_add_expiry_date_metabox' );


function tutsplus_expiry_date_metabox_callback( $post ) { ?>
     
 <form action="" method="post">
         
        <?php        
        //retrieve metadata value if it exists
        $tutsplus_expiry_date = get_post_meta( $post->ID, 'expires', true );
        ?>
         
        <label for "tutsplus_expiry_date"><?php __('Expiry Date', 'tutsplus' ); ?></label>
                 
        <input type="text" class="MyDate" name="tutsplus_expiry_date" value=<?php echo esc_attr( $tutsplus_expiry_date ); ?> / >     

        <script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.MyDate').datepicker({
            dateFormat : 'dd-mm-yy'
        });
    });
    
</script>       
     
    </form>
     
<?php }

function tutsplus_save_expiry_date_meta( $post_id ) {
     
    // Check if the current user has permission to edit the post. */
    if ( !current_user_can( 'edit_post', $post->ID ) )
    return;
     
    if ( isset( $_POST['tutsplus_expiry_date'] ) ) {        
        $new_expiry_date = ( $_POST['tutsplus_expiry_date'] );
        update_post_meta( $post_id, 'expires', $new_expiry_date );      
    }
     
}
add_action( 'save_post', 'tutsplus_save_expiry_date_meta' );


?>
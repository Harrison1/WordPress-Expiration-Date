<?php
/*
Plugin Name: Post Expiration Date
Plugin URI: http://harrisonmcguire.com/
Description: Adds an expiration date to posts, using a the jQuery UI datepicker
Author: Harrison McGuire
Version: 1.0
 */

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

	<?php wp_nonce_field( 'tutsplus_expiry_date_metabox_nonce', 'tutsplus_nonce' ); ?>
     
    <form action="" method="post">
         
        <?php        
        //retrieve metadata value if it exists
        $tutsplus_expiry_date = get_post_meta( $post->ID, 'expires', true );
        ?>
         
        <label for "tutsplus_expiry_date"><?php __('Expiry Date', 'tutsplus' ); ?></label>
                 
        <input type="text" class="MyDate" name="tutsplus_expiry_date" value=<?php echo esc_attr( $tutsplus_expiry_date ); ?> / >            
     
    </form>
     
<?php }

function tutsplus_save_expiry_date_meta( $post_id ) {

	if( !isset( $_POST['tutsplus_nonce'] ) ||
    !wp_verify_nonce( $_POST['tutsplus_nonce'],
    'tutsplus_expiry_date_metabox_nonce'
    ) ) 
    return;
     
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
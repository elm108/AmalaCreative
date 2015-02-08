# AmalaCreative
//* Custom Dog Breed WooCommerce Checkout Field

//* Add the field to the checkout

add_action( 'woocommerce_after_order_notes', 'dog_breed_checkout_field' );
 
function dog_breed_checkout_field ( $checkout ) {
 
echo '<div id="dog_breed_checkout_field"><h2>' . __('Dog Breed') . '</h2>';
 
woocommerce_form_field( 'dog_breed_name', array(
'type' => 'text',
'class' => array('dog-breed-class form-row-wide'),
'label' => __('Enter your Dog Breed'),
'placeholder' => __('e.g. pitbull'),
), $checkout->get_value( 'dog_breed_name' ));
 
echo '</div>';
 
} 

//*Process the checkout

add_action('woocommerce_checkout_process', 'dog_breed_checkout_field_process');
 
function dog_breed_checkout_field_process() {
// Check if set, if its not set add an error.
if ( ! $_POST['dog_breed_name'] )
wc_add_notice( __( 'Please enter your dog breed.' ), 'error' );
} 

//* Update the order meta with field value

add_action( 'woocommerce_checkout_update_order_meta', 'dog_breed_checkout_field_update_order_meta' );
 
function dog_breed_checkout_field_update_order_meta( $order_id ) {
if ( ! empty( $_POST['dog_breed_name'] ) ) {
update_post_meta( $order_id, 'Dog Breed', sanitize_text_field( $_POST['dog_breed_name'] ) );
}
} 

//* Display field value on the order edit page

add_action( 'woocommerce_admin_order_data_after_billing_address', 'dog_breed_checkout_field_display_admin_order_meta', 10, 1 );
function dog_breed_checkout_field_display_admin_order_meta($order){
echo '<p><strong>'.__('Dog Breed').':</strong> ' . get_post_meta( $order->id, 'Dog Breed', true ) . '</p>';
} 


//* Add the field to order emails
add_filter('woocommerce_email_order_meta_keys', 'dog_breed_checkout_field_order_meta_keys');

function dog_breed_checkout_field_order_meta_keys( $keys ) {
$keys['Dog Breed'] = 'dog_breed_name';
return $keys;
}

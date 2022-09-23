<?php defined('ABSPATH') || exit('No direct script access allowed');


add_action('woocommerce_product_options_general_product_data', function(){
    echo '<div>';
        $product = wc_get_product(get_the_ID());

        woocommerce_wp_text_input([
            'id'   => 'product_usd_price',
            'name' => 'product_usd_price',
            'label'=> 'Valor do produto em $',
            'type' => 'number',
            'value'=> $product ? $product->get_meta('converter_price/product_usd_price') : 0,
            'custom_attributes' => [
                'step'  => 0.01
            ]
        ]);
    echo '</div>';
});


add_action('woocommerce_process_product_meta',function(int $productId){
    if (!isset($_POST['product_usd_price'])) return;

    $product = wc_get_product($productId);

    if ($product) :
        $USD = (float) $_POST['product_usd_price'];
        $product->add_meta_data('converter_price/product_usd_price', $USD, true);
        $product->save();
    endif;

}, 99);
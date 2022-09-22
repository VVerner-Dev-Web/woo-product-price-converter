<?php defined('ABSPATH') || exit('No direct script access allowed');


add_action('woocommerce_product_options_general_product_data', function(){
    echo '<div>';
        $product = wc_get_product(get_the_ID());

        woocommerce_wp_text_input([
            'id'   => 'product_brl_price',
            'name' => 'product_brl_price',
            'label'=> 'Valor do produto em R$',
            'type' => 'number',
            'value'=> $product ? $product->get_meta('converter_price/product_brl_price') : 0,
            'custom_attributes' => [
                'step'  => 0.01
            ]
        ]);
    echo '</div>';
});


add_action('woocommerce_process_product_meta',function(int $productId){
    if (!isset($_POST['product_brl_price'])) return;

    $product = wc_get_product($productId);

    if ($product) :
        $BRL = (float) $_POST['product_brl_price'];
        $product->add_meta_data('converter_price/product_brl_price', $BRL, true);
        $product->save();
    endif;

}, 99);
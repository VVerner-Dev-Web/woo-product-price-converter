<?php defined('ABSPATH') || exit('No direct script access allowed');


add_action('woocommerce_product_options_general_product_data', function(){
    echo '<div>';
        $product = wc_get_product(get_the_ID());

        woocommerce_wp_text_input([
            'id'   => 'product_price_in_reais',
            'name' => 'product_price_in_reais',
            'label'=> 'Valor do produto em R$',
            'type' => 'number',
            'value'=> $product ? $product->get_meta('product_price_in_reais') : 0,
            'custom_attributes' => [
                'step'  => 0.01
            ]
        ]);
    echo '</div>';
});


add_action('woocommerce_process_product_meta',function(int $productId){
    if (!isset($_POST['product_price_in_reais'])) return;

    $product = wc_get_product($productId);

    if ($product) :
        $priceInReais = (float) $_POST['product_price_in_reais'];
        $product->add_meta_data('product_price_in_reais', $priceInReais,true);
        $product->save();
    endif;

}, 99);
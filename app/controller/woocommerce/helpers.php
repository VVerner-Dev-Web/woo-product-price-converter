<?php

use VVerner\WoocommerceProductPriceConverter\Api;

defined('ABSPATH') || exit('No direct script access allowed');

function setAllWooCommerceProductsPrice():void
{
    $bidValue = new Api();
    $bidValue = $bidValue->getBidValue('USD','BRL');
    if ($bidValue) :
        $products = wc_get_products([
            'limit' => -1
        ]);

        foreach ($products as $product) :
            $dollarValue = (float) $product->get_meta('converter_price/product_usd_price');

            if (!$dollarValue) continue;

            $newProductPrice = $dollarValue * $bidValue;
            $newProductPrice = round($newProductPrice, 2);
            $product->set_regular_price($newProductPrice);
            $product->add_meta_data('converter_price/product_usd_price_last_update',date('y-m-d h:i:s'), true);
            $product->save();
        endforeach;
    endif;
}


add_filter('woocommerce_product_get_price', function($price, $product){
    //Valor a ser mostrado
    $dollarValue = $product->get_meta('converter_price/product_usd_price');
    return $dollarValue ? $dollarValue : $price;
}, 10, 2);

add_filter('woocommerce_currency',function($currency){
    //Moeda
    return $currency;
});

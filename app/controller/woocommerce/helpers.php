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
            $product->add_meta_data('converter_price/product_usd_price_last_update',date('Y-m-d h:i:s'), true);
            $product->save();
        endforeach;
    endif;
}


add_filter( 'woocommerce_get_price_suffix', function($html, $product, $price, $qty) {
    $dollarValue = (float) $product->get_meta('converter_price/product_usd_price');
    
    if ($dollarValue) : 
        $html .= ' <small>$ ('. number_format($dollarValue, 2, ',', ',') .')</small>';
    endif;
    
    return $html;
}, 99, 4 );

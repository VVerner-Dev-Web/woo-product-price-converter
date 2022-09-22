<?php

use VVerner\WoocommerceProductPriceConverter\Api;

defined('ABSPATH') || exit('No direct script access allowed');

function setAllWooCommerceProductsPrice():void
{
    $bidValue = new Api();
    $bidValue = $bidValue->getBidValue('USD', 'BRL');
    
    if ($bidValue) :
        $products = wc_get_products([
            'limit' => -1
        ]);

        foreach ($products as $product) :
            $realValue = (float) $product->get_meta('converter_price/product_brl_price');

            if (!$realValue) continue;

            $newProductPrice = $realValue / $bidValue;
            $newProductPrice = round($newProductPrice, 2);
            $product->set_regular_price($newProductPrice);
            $product->add_meta_data('converter_price/product_brl_price_last_update',date('y-m-d h:i:s'), true);
            $product->save();
        endforeach;
    endif;
}
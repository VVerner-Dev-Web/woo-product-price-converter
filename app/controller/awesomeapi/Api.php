<?php

namespace VVerner\WoocommerceProductPriceConverter;

use stdClass;
use WP_Error;

defined('ABSPATH') || exit('No direct script access allowed');

class Api
{
    private const URL = 'https://economia.awesomeapi.com.br/json/last/';

    public function getBidValue(string $from, string $to): float
    {
        $response = $this->fetch($from .'-'. $to);
        return $response ? (float) $response->USDBRL->bid : 0;
    }

    private function fetch(string $endpoint): ?stdClass
    {
        $request  = wp_remote_get(self::URL . $endpoint);
        $response = is_wp_error($request) ? null : wp_remote_retrieve_body($request);
        $errors   = $this->traitErrors( $response );
        return $errors ? null : json_decode($response);
    }

    private function traitErrors(string $response): ?WP_Error
    {
        if (!$response) :
            return new WP_Error(-1, 'Retorno vazio da API');
        endif;

        if($response === '') :
            return new WP_Error(-1, 'Url não encontrada');
        endif;

        return null;
    }
}
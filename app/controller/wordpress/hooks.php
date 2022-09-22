<?php defined('ABSPATH') || exit('No direct script access allowed');

add_action('admin_menu', function(){
    add_menu_page(
        'Configurações de conversão de preços',
        'Config. conversão de preços',
        'manage_options',
        'conversion-setup',
        'priceConversionSetupPage',
        'dashicons-admin-generic',
        2
    );
});

function priceConversionSetupPage():void
{
   require VVWPPC_APP.'views/conversion-setup-page.php';
}

add_action( 'converter/update-products', 'setAllWooCommerceProductsPrice' );


function converterPrice_intervalUpdateProductsPrice_recurrence( $schedules ) {
    $interval = get_option('converter_price/update_interval_time');
	$schedules['Converter-price-Interval'] = array(
		'display' => __( "Tempo definido na configuração", 'textdomain' ),
		'interval' => $interval,
    );
	return $schedules;
}
add_filter( 'cron_schedules', 'converterPrice_intervalUpdateProductsPrice_recurrence' );

// Schedule Cron Job Event
function converterPrice_intervalUpdateProductsPrice() {
	if ( !wp_next_scheduled( 'converter/update-products' ) ) {
		wp_schedule_event( time(), 'Converter-price-Interval', 'converter/update-products' );
	}
}

add_action( 'wp', 'converterPrice_intervalUpdateProductsPrice' );

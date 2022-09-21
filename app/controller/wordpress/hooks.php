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
   require VVWPPC_APP.'views\conversion-setup-page.php';
}

// Scheduled Action Hook
function updateProductsPrice(): void
{
   error_log("Testes"); 
}
add_action( 'updateProductsPrice', 'updateProductsPrice' );


function intervalUpdateProductsPrice_recurrence( $schedules ) {
    $interval = get_option('update_interval_time');
	$schedules['Custom'] = array(
		'display' => __( "A cada $interval segundos", 'textdomain' ),
		'interval' => $interval,
    );
	return $schedules;
}
add_filter( 'cron_schedules', 'intervalUpdateProductsPrice_recurrence' );

// Schedule Cron Job Event
function intervalUpdateProductsPrice() {
	if ( !wp_next_scheduled( 'updateProductsPrice' ) ) {
		wp_schedule_event( time(), 'Custom', 'updateProductsPrice' );
	}
}

add_action( 'init', 'intervalUpdateProductsPrice' );

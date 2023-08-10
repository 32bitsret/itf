<?php
/**
  Plugin Name: ITF Remita WooCommerce Payment Gateway
  Plugin URI:  https://www.remita.net
  Description: Remita Woocommerce Payment gateway allows you to accept payment on your Woocommerce store.
  Author:      ISAAC ODEH
  Author URI:  https://isaac-odeh-portfolio.netlify.app/
  Version:     1.0

 */






add_filter('woocommerce_payment_gateways', 'woocommerce_add_remita_gateway');
 function woocommerce_add_remita_gateway($methods)
 {
     $methods[] = 'wc_remita';
     return $methods;
 }


add_filter('plugins_loaded', 'wc_remita_init');

// add_action('init', 'wc_remita_init', 10, 0);




function wc_remita_init()
{
    // if (!class_exists('WC_Payment_Gateway')) {
    //     return;
    // }

    class WC_Remita extends WC_Payment_Gateway
    {
        private $paymenthash = "";

        public function __construct()
        {
            // global $woocommerce;

            // paymenthash


            $this->id           = 'itf-remita';
            $this->icon         = apply_filters('woocommerce_remita_icon', plugins_url('assets/images/remita-payment-options.png', __FILE__));
            $this->method_title = __('Remita', 'woocommerce');
            $this->method_description = 'This is a custom payment gateway for ITF course payments'; // will be displayed on the options page

          	// gateways can support subscriptions, refunds, saved payment methods,
          	// but in this tutorial we begin with simple payments
          	$this->supports = array(
          		'products'
          	);


            // Load the form fields.
            $this->init_form_fields();

            // Load the settings.
            $this->init_settings();

            // Define user set variables
            $this->title = $this->get_option( 'title' );
            $this->userName = $this->get_option( 'userName' );
            $this->password = $this->get_option( 'password' );

          	$this->description = $this->get_option( 'description' );
          	$this->enabled = $this->get_option( 'enabled' );

            // This action hook saves the settings
          	add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );


            add_action( 'wp_enqueue_scripts', array( $this, 'payment_scripts' ) );



            // You can also register a webhook here -> when all set
            add_action( 'woocommerce_api_itf_payment',  array($this, 'itf_payment_handler')  );

            //Filters
            add_filter('woocommerce_currencies', array(
                $this,
                'add_ngn_currency'
            ));
            add_filter('woocommerce_currency_symbol', array(
                $this,
                'add_ngn_currency_symbol'
            ), 10, 2);

         

        }
      
        



        function init_form_fields()
        {

            $this->form_fields = array(
                'title' => array(
                    'title' => 'Title',
                    'type' => 'text',
                    'default' => 'Custom ITF Remita Gateway'
                ),
                'userName' => array(
                    'title' => 'User Name',
                    'type' => 'text',
                    'description' => 'The User name used for authorization',
                    'desc_tip' => true,

                ),

                'password' => array(
                  'title' => 'Password',
                  'type' => 'text',
                  'description' => 'The User password used for authorization',
                  'desc_tip' => true,
                ),


                'description' => array(
            			'title'       => 'Description',
            			'type'        => 'textarea',
            			'description' => 'This controls the description which the user sees during checkout.',
            			'default'     => 'Proceed to make payment via remita payment gateway.',
            		),

                'enabled' => array(
            			'title'       => 'Enable/Disable',
            			'label'       => 'Enable ITF Custom Remita Payment Gateway',
            			'type'        => 'checkbox',
            			'description' => '',
            			'default'     => 'no'
            		),


                'testmode' => array(
            			'title'       => 'Test Mode',
            			'label'       => 'This puts the plugin in test mode and will it to work without an ssl certificate.',
            			'type'        => 'checkbox',
            			'description' => '',
            			'default'     => 'yes'
            		),

            );

        }



        function add_ngn_currency($currencies)
        {
            $currencies['NGN'] = __('Nigerian Naira (NGN)', 'woocommerce');
            return $currencies;
        }

        function add_ngn_currency_symbol($currency_symbol, $currency)
        {
            switch ($currency) {
                case 'NGN':
                    $currency_symbol = '₦';
                    break;
            }

            return $currency_symbol;
        }







        public function payment_scripts()
        {

          // we need JavaScript to process a token only on cart/checkout pages, right?
          if ( ! is_cart() && ! is_checkout() && ! isset( $_GET['pay_for_order'] ) ) {
            return;
          }

          // if our payment gateway is disabled, we do not have to enqueue JS too
          if ( 'no' === $this->enabled ) {
            return;
          }

          // no reason to enqueue JavaScript if API keys are not set
          if ( empty( $this->private_key ) || empty( $this->publishable_key ) ) {
            return;
          }

          // do not work with card detailes without SSL unless your website is in a test mode
          if ( ! $this->testmode && ! is_ssl() ) {
            return;
          }





        }

        public function process_payment( $order_id ) {

        	global $woocommerce;

        	// we need it to get any order detailes
        	$order = wc_get_order( $order_id );
          $data = $order->get_data();
          $order = wc_get_order($order_id);
          $redirectUrl ="https://itflearningpay.dcontroller.com.ng/makepayment?nd=1&tr=";








        	/*
         	 * Array with parameters for API interaction
        	 */
        	$args = array(
            "authorization"=> array(
              "userName"=> $this->userName,
              "password"=> $this->password
            ),
            "payerName"=> $data['billing']['first_name']." " .$data['billing']['last_name'],
            "payerEmail"=> $data['billing']['email'],
            "transactionNo"=> $order->get_order_key(),
            // "transactionNo"=> $order_id,
            "amount"=> $order->get_total(),
            "narration"=> "Payment for Course",
            "phoneNo"=> $data['billing']['phone']
          );



        	/*
        	 * Your API interaction could be built with wp_remote_post()
         	 */
        	 $response = wp_remote_post( "https://itflearningpay.dcontroller.com.ng/api/ItfelearningDevApi/makepayment",  array(
        
          	'headers'     => array( 'Content-type' => 'application/json'),
          	'body'        => json_encode($args)
          ));


        	 if( !is_wp_error( $response ) ) {

        		 $body = json_decode( $response['body'], true );
            //  return array( // for testing
            //      'result' => 'success',
            //      'redirect' => $redirectUrl . $response['body'] . json_encode($args) .json_encode($body)
            //  );

        		 // it could be different depending on your payment processor
        		 if ( $body['status'] == 'success' ) {

               return array(
                   'result' => 'success',
                   'redirect' => $redirectUrl . $body['paymenthash']. '&key='.$order->get_order_key().'&id='.$order_id
               );



        		 } else {
        			wc_add_notice(  'Please try again.', 'error' );
        			return;
        		}

        	} else {
        		wc_add_notice(  'Connection error.', 'error' );
        		return;
        	}

        }



        public function itf_payment_handler()
        {
          header( 'HTTP/1.1 200 OK' );
          $order_key = isset($_GET['transactionNo']) ? $_GET['transactionNo'] : null;
          $order_id = wc_get_order_id_by_order_key($order_key);
          $order = wc_get_order( $order_id );
          

          if($_GET['status']== 1) {
            // success
            
            $order->payment_complete();
            
            wc_empty_cart();
            wc_add_notice('Your payment is received!', 'success' );

            return wp_redirect($this->get_return_url( $order ));


          }
          if($_GET['status']== 2) {
              // Show err page
              wc_add_notice(  'Please try again.', 'error' );
			        // return;
              return wp_redirect($this->get_return_url( $order ));



          }

          if($_GET['status']== 3) {
              // Alert or show user that  order was canceled
              // will be best if redirect to order page & notify user that order is complete/err/canceled
              wc_add_notice(  'OOps! You canceled this transaction!.', 'error' );
              return wp_redirect($this->get_return_url( $order ));
		        
          }
          // var_dump( ['id' => $_GET['order_id'],'test'=> wc_get_order($_GET['order_id'] )]);

          wp_die(); 



          // update_option('webhook_debug', $_GET);
        }

        




    }



}

?>

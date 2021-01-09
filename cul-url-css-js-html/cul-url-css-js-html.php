<?php

/**
 * A plugin that adds CSS for specific URLs
 *
 * @package cul-url-css-js-html
 *
 * Plugin Name:       CUL - CSS, JS or HTML for specific URLs
 * Description:       Plugin that adds CSS for specific URLs
 * Version:           1.0
 * Author:            CUL
 */


// Add meta box for collections information
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];


/***
CSS if mi-cuenta/pagos in URL for all App webview 
***/
if (strpos($url,'mi-cuenta/pagos') !== false) {
    echo '<style>
                .float2 { 
                    display:none;!important; 
                }
                .float { 
                    display:none;!important; 
                }
                .xoo-wsc-basket { 
                    display:none;!important; 
                }
          </style>';
} 


/***
CSS if mobile=true in URL for all App webview 
***/
if (strpos($url,'mobile=true') !== false) {
    echo '<style>
                .float2 { 
                    display:none;!important; 
                }
                .float { 
                        display:none;!important; 
                }
                .xoo-wsc-basket { 
                        display:none;!important; 
                }
                .site-footer { 
                        display:none;!important; 
                }
                .header { 
                        display:none;!important; 
                }
                .woocommerce-MyAccount-navigation { 
                        display:none;!important; 
                }

          </style>';
} 
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Product / category image base URL (SMA uploads)
    |--------------------------------------------------------------------------
    |
    | Relative filenames in sma_products.image and sma_product_photos.photo
    | are prefixed with this URL.
    |
    | Example full URL:
    |   https://erp.chancelaptops.com/assets/uploads/{filename}.png
    |
    */

    'image_base_url' => rtrim(env('PRODUCT_IMAGE_BASE_URL', 'https://erp.chancelaptops.com/assets/uploads'), '/') . '/',

    /*
    | WhatsApp number for wholesale / In Stock UAE purchase enquiries
    | and the site floating WhatsApp button (digits only for wa.me).
    */
    'whatsapp_number' => preg_replace('/\D+/', '', env('WHATSAPP_NUMBER', '94713043700')),
    'whatsapp_display' => env('WHATSAPP_DISPLAY', '+94 71 304 3700'),
    'landline_number' => preg_replace('/\D+/', '', env('LANDLINE_NUMBER', '94812575733')),
    'landline_display' => env('LANDLINE_DISPLAY', '+94 81 257 5733'),
    'facebook_url' => env('FACEBOOK_URL', 'https://www.facebook.com/profile.php?id=61591727103570'),
    'tiktok_url' => env('TIKTOK_URL', 'https://www.tiktok.com/@chance.laptops'),
    'wholesale_min_units' => 5,

];

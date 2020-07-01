<?php

namespace odt\api;

class product {
    public function single(){
        wp_send_json([
            'status' => true,
            'data' => [
                'id' => 1,
                'title' => 'sony vaio 15 inch',
                'regular_price' => 1400,
                'sale_price' => 1350
            ]
        ]);
    }
}

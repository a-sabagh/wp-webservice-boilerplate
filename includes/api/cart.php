<?php

namespace odt\api;

class cart {
    public function get(){
        wp_send_json([
            'status' => true,
            'data' => [
                [
                    'id' => 1,
                    'title' => 'product1'
                ],
                [
                    'id' => 2,
                    'title' => 'product2'
                ]
            ]
        ]);
    }
}
<?php

namespace odt\providers;

class api_provider {

    public $api_mapper;
    public $service_provider;
    public $api_slug;

    public function __construct($service_provider, $api_mapper ,$api_slug) {
        $this->api_slug = $api_slug;
        $this->service_provider = $service_provider;
        $this->api_mapper = $api_mapper;
        add_action("template_redirect", array($this, "template_redirect"));
    }

    public function template_redirect() {
        $module = get_query_var("{$this->api_slug}_module");
        if (empty($module)) {
            return;
        }
        $action = get_query_var("{$this->api_slug}_action");
        $params = get_query_var("{$this->api_slug}_params");
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        $object = $this->service_provider->get($this->api_mapper[$module]);
        if (!is_object($object)) {
            wp_send_json(['error' => "Class {$module} not exist"]);
            return;
        }
        if (!isset($action)) {
            $object->index();
            return;
        }
        $object->{$action}($params);
    }
    
}

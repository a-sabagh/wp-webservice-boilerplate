<?php 

namespace odt;

use odt\providers\service_provider;
use odt\providers\api_provider;

class init {
    
    const first_flush_option = "first_flush_permalinks";

    public $version;
    public $api_slug;

    public function __construct($version, $api_slug) {
        $this->version = $version;
        $this->api_slug = $api_slug;
        add_action("init", array($this, "add_rewrite_rule"));
        add_action("admin_notices", array($this, "first_flush_notice"));
        add_action("update_option_permalink_structure", function() {
            update_option(self::first_flush_option, true);
        });
        $this->boot_service_provider();
    }

    public function add_rewrite_rule() {
        add_rewrite_rule("^{$this->api_slug}/([^/]*)/?([^/]*)/?([^/]*)/?$", 'index.php?' . $this->api_slug . '_module=$matches[1]&' . $this->api_slug . '_action=$matches[2]&' . $this->api_slug . '_params=$matches[3]', "top");
        add_rewrite_tag("%{$this->api_slug}_module%", "([^/]*)");
        add_rewrite_tag("%{$this->api_slug}_action%", "([^/]*)");
        add_rewrite_tag("%{$this->api_slug}_params%", "([^/]*)");
    }

    public function first_flush_notice() {
        if (get_option(self::first_flush_option)) {
            return;
        }
        ?>
        <div class="error">
            <p>
                <?php esc_html_e("To make the api-boilerplate plugin worked Please first "); ?>
                <a href="<?php echo get_admin_url(); ?>/options-permalink.php" title="<?php esc_attr_e("Permalink Settings") ?>" >
                    <?php esc_html_e("Flush rewrite rules"); ?>
                </a>
            </p>
        </div>
        <?php
    }

    public function boot_service_provider() {
        # Services
        $services = array(
            #Controllers\Api
            \odt\api\product::class => trailingslashit(__DIR__) . "api/product.php",
            \odt\api\cart::class => trailingslashit( __DIR__ ) . "api/cart.php",
        );
        $api_mapper = array(
            "product" => \odt\api\product::class,
            "cart" => \odt\api\cart::class,
        );
        # BootServices
        require_once trailingslashit(__DIR__) . "providers/service_provider.php";
        require_once trailingslashit(__DIR__) . "providers/api_provider.php";
        $service_provider = new service_provider($services);
        new api_provider($service_provider,$api_mapper,$this->api_slug);
    }

}
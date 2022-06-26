<?php
class Loja5_Shipping_Braspress_R extends Loja5_Shipping_Braspress {
    
    public $code = 'R';
    
    public function __construct( $instance_id = 0 ) {
        $this->id           = 'braspress-r';
        $this->method_title = __( 'Braspress - Rodoviário', 'loja5-woo-braspress' );
        $this->more_link    = 'https://www.braspress.com/';
        parent::__construct( $instance_id );
    }
    
}

class Loja5_Shipping_Braspress_A extends Loja5_Shipping_Braspress {
    
    public $code = 'A';
    
    public function __construct( $instance_id = 0 ) {
        $this->id           = 'braspress-a';
        $this->method_title = __( 'Braspress - Aéreo', 'loja5-woo-braspress' );
        $this->more_link    = 'https://www.braspress.com/';
        parent::__construct( $instance_id );
    }
    
}
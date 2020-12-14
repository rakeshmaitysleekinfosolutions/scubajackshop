<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FrontendController extends BaseController {
    public function __construct() {
        parent::__construct();
        //Currency_model::factory()->refresh(true, 'USD');
        $this->onLoad();
    }
    public function onLoad() {
        $this->options['currency'] =  $this->currency->getCurrency('USD');
        if($this->ecart->hasProducts()) {
            setSession('total',sprintf('%s item(s) - %s', $this->ecart->countProducts() , $this->currency->format($this->ecart->totals()['total'], $this->options['currency']['code'])));
        } else {
            setSession('total', '0 item(s) - $0.00');
        }

    }
}

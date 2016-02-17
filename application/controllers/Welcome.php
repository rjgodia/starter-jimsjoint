<?php

/**
 * Our homepage.
 * 
 * Present a summary of the completed orders.
 * 
 * controllers/welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'Jim\'s Joint!';
        $this->data['pagebody'] = 'welcome';

        // Get all the completed orders
        //FIXME



        // Build a multi-dimensional array for reporting
        $this->data['orders'] = array();
        foreach ($this->orders->some('status', 'c') as $order) {
            $this1 = array(
                'num' => $order->num,
                'datetime' => $order->date,
                'amount' => $order->total
            );
            $this->data['orders'][] = $this1;
        }
        
        $this->render();
    }

}

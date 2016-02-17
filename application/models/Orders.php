<?php

/**
 * Data access wrapper for "orders" table.
 *
 * @author jim
 */
class Orders extends MY_Model {

    // constructor
    function __construct() {
        parent::__construct('orders', 'num');
    }

    // add an item to an order
    function add_item($num, $code) {
        $CI =& get_instance();


        if($CI->orderitems->exists($num, $code))
        {
            $orderitem = $CI->orderitems->get($num, $code);
            $orderitem->quantity++;

            $CI->orderitems->update($orderitem);
        }
        else
        {
            $orderitem = $CI->orderitems->create();
            $orderitem->order = $num;
            $orderitem->item = $code;
            $orderitem->quantity = 1;

            $CI->orderitems->add($orderitem);
        }
    }

    // calculate the total for an order
    function total($num) {
        $CI =& get_instance();
        $items = $CI->orderitems->group($num);
        $result = 0.0;

        foreach($items as $item)
        {
            $menu = $CI->menu->get($item->item);
            $result += $item->quantity * $menu->price;
        }

        return $result;
    }

    // retrieve the details for an order
    function details($num) {
        
    }

    // cancel an order
    function flush($num) {
        
    }

    // validate an order
    // it must have at least one item from each category
    function validate($num) {

        $CI =& get_instance();
        $items = $CI->orderitems->group($num);
        $gotem = array();

        foreach($items as $item)
        {
            $menu = $CI->menu->get($item->item);
            $gotem[$menu->category] = 1;
        }

        return isset($gotem['m']) && isset($gotem['d']) && isset($gotem['s']);
    }

}

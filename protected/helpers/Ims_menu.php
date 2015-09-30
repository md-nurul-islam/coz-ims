<?php

class Ims_menu{
    
    public static $supplier_menu = array(
    	array('label'=>'Add Supplier', 'url'=>array('create')),
    	array('label'=>'Supplier List', 'url'=>array('index')),
    );
    
    public static $product_menu = array(
    	array('label'=>'Add Category', 'url'=>array('category/create')),
    	array('label'=>'Category List', 'url'=>array('category/')),
    	array('label'=>'Add Product', 'url'=>array('manage/create')),
    	array('label'=>'Product List', 'url'=>array('manage/')),
    	array('label'=>'Generate Barcode', 'url'=>array('manage/barcode')),
    );
    
    public static $customer_menu = array(
    	array('label'=>'Add Customer', 'url'=>array('create')),
    	array('label'=>'Customer List', 'url'=>array('index')),
    );
    
    public static $purchase_menu = array(
    	array('label'=>'Purchase Product', 'url'=>array('createsingle')),
//    	array('label'=>'Purchase Product', 'url'=>array('create')),
    	array('label'=>'Purchase List', 'url'=>array('index')),
    );
    
    public static $sale_menu = array(
    	array('label'=>'Sale Product', 'url'=>array('create')),
    	array('label'=>'Sales List', 'url'=>array('index')),
        array('label'=>'Advance Sale', 'url'=>array('advance_sale')),
        array('label'=>'Advance Sale List', 'url'=>array('advance_sale_list')),
    );

    public static $exchange_menu = array(
    	array('label'=>'Exchange Product', 'url'=>array('create')),
    	array('label'=>'Exchange List', 'url'=>array('index')),
    );
    
    public static $report_menu = array(
    	array('label'=>'Sale Report', 'url'=>array('/reports/sale')),
    	array('label'=>'Advance Sale Report', 'url'=>array('/reports/sale/advance_sale')),
    	array('label'=>'Purchase Report', 'url'=>array('/reports/purchase')),
    	array('label'=>'Excheang Report', 'url'=>array('/reports/exchange')),
    );
    
}
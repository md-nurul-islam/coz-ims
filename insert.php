<?php

set_time_limit(0);
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes

$db_con = mysql_connect('localhost', 'root', '1234567asd#');

$db = mysql_select_db('coz_ims_db', $db_con);

$now = date('Y-m-d H:i:s', time());

/**
 * Product Category Migration Starts
 */
//$cat_sql = "SELECT * FROM category_details";
//$cat_res = mysql_query($cat_sql);
//
//while ($row = mysql_fetch_assoc($cat_res)) {
//
//    $cat_name = trim($row['category_name']);
//    $cat_disc = (empty($row['category_description']) || $row['category_description'] == '') ? NULL : trim($row['category_description']);
//
//    $cat_ins = "INSERT INTO `cims_category_details` (`category_name`, `category_description`) VALUES ('" . $cat_name . "', '" . $cat_disc . "')";
//    mysql_query($cat_ins);
//}
//echo 'category migrated.<br />';

/**
 * Product Category Migration Ends
 */

/**
 * Product Stock Insertation Starts
 */
$cat_sql = "SELECT id FROM cims_product_details";
$cat_res = mysql_query($cat_sql);

while ($row = mysql_fetch_assoc($cat_res)) {

    $cat_ins = "INSERT INTO `cims_product_stock_avail` (`product_details_id`, `quantity`) VALUES ('" . $row['id'] . "', '" . 0 . "')";
    mysql_query($cat_ins);
}
echo 'Products inserted into stock migrated.<br />';

/**
 * Product Stock Insertation Ends
 */

/**
 * Product Migration Starts
 */
//$prod_sql = "SELECT stock_name, category FROM stock_details";
//$prod_res = mysql_query($prod_sql);
//
//while ($row = mysql_fetch_assoc($prod_res)) {
//
//    $cat_sql = "SELECT id FROM cims_category_details WHERE category_name = '".trim($row['category'])."'";
//    $cat_res = mysql_query($cat_sql);
//    $cat_row = mysql_fetch_assoc($cat_res);
//    
//    $cate_id = $cat_row['id'];
//    
//    $prod_name = trim($row['stock_name']);
//    $prod_name = str_replace('&#34;', '"', $prod_name);
//    
//    $prod_ins = "INSERT INTO `cims_product_details` (`category_id`, `supplier_id`, `product_name`, `create_date`, `update_date`)"
//            . " VALUES"
//            . " ('" . $cate_id . "', '1', '".$prod_name."', '".$now."', '".$now."')";
//    mysql_query($prod_ins);
//}
//echo 'product migrated.<br />';

/**
 * Product Migration Ends
 */
/**
 * Purchase Migration Starts
 */
//$pur_sql = "SELECT * FROM stock_entries";
//$pur_res = mysql_query($pur_sql);
//
//while ($row = mysql_fetch_assoc($pur_res)) {
//
//    $prod_name = trim($row['stock_name']);
//    $prod_name = str_replace('&#34;', '"', $prod_name);
//
//    $prod_sql = "SELECT id, category_id FROM cims_product_details WHERE product_name = '" . $prod_name . "'";
//    $prod_res = mysql_query($prod_sql);
//    $prod_row = mysql_fetch_assoc($prod_res);
//
//    if (!$prod_row) {
//        $prod_ins = "INSERT INTO `cims_product_details` (`category_id`, `supplier_id`, `product_name`, `create_date`, `update_date`)"
//                . " VALUES"
//                . " ('" . 27 . "', '1', '" . $prod_name . "', '" . $now . "', '" . $now . "')";
//        
//        mysql_query($prod_ins);
//        $prod_row['id'] = mysql_insert_id();
//        $prod_row['category_id'] = 27;
//    }
//    
//    $pur_ins = "INSERT INTO `cims_product_stock_entries` ("
//            . " `purchase_id`,"
//            . "`billnumber`,"
//            . "`ref_num`,"
//            . "`supplier_id`,"
//            . "`category_id`,"
//            . "`product_details_id`,"
//            . "`quantity`,"
//            . "`purchase_price`,"
//            . "`selling_price`,"
//            . "`purchase_date`,"
//            . "`payment_type`,"
//            . "`note`,"
//            . "`item_subtotal`,"
//            . "`grand_total_payable`,"
//            . "`grand_total_paid`,"
//            . "`grand_total_balance`,"
//            . "`due_payment_date`,"
//            . "`serial_num`"
//            . ")"
//            . " VALUES"
//            . " ("
//            . "'" . trim($row['stock_id']) . "',"
//            . "'" . trim($row['billnumber']) . "',"
//            . "'" . trim($row['ref_num']) . "',"
//            . "'1',"
//            . "'" . trim($prod_row['category_id']) . "',"
//            . "'" . trim($prod_row['id']) . "',"
//            . "'" . trim($row['quantity']) . "',"
//            . "'" . trim($row['company_price']) . "',"
//            . "'" . trim($row['selling_price']) . "',"
//            . "'" . date('Y-m-d', strtotime(trim($row['date']))) . "',"
//            . "'1',"
//            . "'" . trim($row['description']) . "',"
//            . "'" . trim($row['total']) . "',"
//            . "'" . trim($row['subtotal']) . "',"
//            . "'" . trim($row['payment']) . "',"
//            . "'" . trim($row['balance']) . "',"
//            . "'" . date('Y-m-d', strtotime(trim($row['due']))) . "',"
//            . "'" . trim($row['count1']) . "'"
//            . ")";
//    
//    mysql_query($pur_ins);
//}
//echo 'Purchase migrated.';
/**
 * Purchase Migration Ends
 */
//
///**
// * Sale Migration Starts
// */
//$sale_sql = "SELECT * FROM stock_sales";
//$sale_res = mysql_query($sale_sql);
//
//while ($row = mysql_fetch_assoc($sale_res)) {
//
//    $prod_name = trim($row['stock_name']);
//    $prod_name = str_replace('&#34;', '"', $prod_name);
//
//    $prod_sql = "SELECT id, category_id FROM cims_product_details WHERE product_name = '" . $prod_name . "'";
//    $prod_res = mysql_query($prod_sql);
//    $prod_row = mysql_fetch_assoc($prod_res);
//
//    $ref_num = trim($row['ref_num']);
//    if ($ref_num == '' || empty($ref_num) || $ref_num == NULL) {
//        $ref_num = 0;
//    }
//
//    if ($prod_row != false) {
//
//        $sale_ins = "INSERT INTO `cims_product_stock_sales` ("
//                . " `sales_id`,"
//                . "`billnumber`,"
//                . "`ref_num`,"
//                . "`supplier_id`,"
//                . "`category_id`,"
//                . "`product_details_id`,"
//                . "`quantity`,"
//                . "`item_selling_price`,"
//                . "`sale_date`,"
//                . "`payment_method`,"
//                . "`note`,"
//                . "`item_subtotal`,"
//                . "`grand_total_payable`,"
//                . "`grand_total_paid`,"
//                . "`grand_total_balance`,"
//                . "`due_payment_date`,"
//                . "`serial_num`"
//                . ")"
//                . " VALUES"
//                . " ("
//                . "'" . trim($row['transactionid']) . "',"
//                . "'" . trim($row['billnumber']) . "',"
//                . "'" . $ref_num . "',"
//                . "'1',"
//                . "'" . trim($prod_row['category_id']) . "',"
//                . "'" . trim($prod_row['id']) . "',"
//                . "'" . trim($row['quantity']) . "',"
//                . "'" . trim($row['selling_price']) . "',"
//                . "'" . date('Y-m-d', strtotime(trim($row['date']))) . "',"
//                . "'1',"
//                . "'" . trim($row['description']) . "',"
//                . "'" . trim($row['amount']) . "',"
//                . "'" . trim($row['grand_total']) . "',"
//                . "'" . trim($row['grand_total']) . "',"
//                . "'" . trim($row['balance']) . "',"
//                . "'" . date('Y-m-d', strtotime(trim($row['due']))) . "',"
//                . "'" . trim($row['count1']) . "'"
//                . ")";
//
//        mysql_query($sale_ins);
//    }
//}
//echo 'Sale migrated.';
/**
 * Sale Migration Ends
 */
/**
 * Stock Migration Starts
 */
//$prod_sql = "SELECT id FROM cims_product_details ORDER BY id";
//$prod_res = mysql_query($prod_sql);
//
//while ($row = mysql_fetch_assoc($prod_res)) {
//
//    $prod_pur = "SELECT SUM(quantity) AS qty FROM cims_product_stock_entries WHERE product_details_id = '" . $row['id'] . "'";
//    $prod_pur_res = mysql_query($prod_pur);
//    $prod_pur_row = mysql_fetch_assoc($prod_pur_res);
//
//    $prod_sal = "SELECT SUM(quantity) AS qty FROM cims_product_stock_sales WHERE product_details_id = '" . $row['id'] . "'";
//    $prod_sal_res = mysql_query($prod_sal);
//    $prod_sal_row = mysql_fetch_assoc($prod_sal_res);
//
//    $pur_stock = intval($prod_pur_row['qty']);
//    $sal_stock = intval($prod_sal_row['qty']);
//
//    $stock = $pur_stock - $sal_stock;
//    $stock = ($stock > 0) ? $stock : 0;
//    
//    $stock_ins = "INSERT INTO `cims_product_stock_avail` ("
//            . "`product_details_id`,"
//            . "`quantity`"
//            . ")"
//            . " VALUES"
//            . " ("
//            . "'" . $row['id'] . "',"
//            . "'" . $stock . "'"
//            . ")";
//    
//    mysql_query($stock_ins);
//}
//echo 'Stock migrated.';
/**
 * Sale Migration Ends
 */
//exit;

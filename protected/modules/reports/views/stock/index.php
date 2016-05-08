<?php
/* @var $this PurchaseController */
/* @var $model ProductStockEntries */

$this->breadcrumbs = array(
    'Product Sales' => array('index'),
    'Sales List',
);

$this->menu = Ims_menu::$report_menu;
?>



<div class="report_title">
    Stock Report (*** showing items with at-least one quantity in stock)
</div>

<div>
    <?php $this->widget('DataTable', $datatable); ?>
</div>


<style type="text/css">

    table, td, th {
        border: 1px solid #000;
        text-align: center;
    }
    .report_title {
        font-size: 18px;
        font-weight: bold;
        margin-left: auto;
        margin-right: auto;
        padding: 10px 0 30px;
        text-align: center;
        width: 90%;
    }
    .report_table {
        width: 90%;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }
</style>
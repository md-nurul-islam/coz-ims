<div class="note">
    *** 100 barcode will be generated at each execution. Once barcode is generated then it will be removed from the list.
</div>

<div class="clearfix"></div>

<?php $this->renderPartial('_barcode_partial', array('purchaseRecords' => $purchaseRecords, 'pdf' => $pdf)); ?>

<div class="clearfix"></div>

<a class="export-btn" href="/product/manage/downloadBarcode">Export PDF</a>

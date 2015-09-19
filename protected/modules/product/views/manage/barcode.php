<div class="note">
    *** 100 barcode will be generated at each execution. Once barcode is generated then it will be removed from the list.
</div>

<div class="clearfix"></div>

<?php $this->renderPartial('_barcode_partial', array('purchaseRecords' => $purchaseRecords, 'pdf' => $pdf, 'barcode' => $barcode,)); ?>

<div class="clearfix"></div>

<a id="barcode_file_list" class="export-btn" href="javascript:void(0);">Export PDF</a>

<div class="clearfix"></div>
<div id="file_list" class="hidden">
    <a href=""></a>
</div>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<style type="text/css">
    .hidden {
        display: none;
    }
    .export-btn {
        background-color: #519cc6;
        border: medium none;
        border-radius: 5px;
        box-shadow: 0 0 6px 1px #ccc;
        color: #ffffff !important;
        cursor: pointer;
        float: left;
        font-size: 15px;
        font-weight: bold;
        height: 35px;
        margin-bottom: 20px;
        margin-top: 20px;
        padding: 15px 15px 0;
        text-align: center;
        text-decoration: none;
        width: 100px;
    }
    .export-btn:hover {
        background-color: #0f547e;
        color: #ffffff;
        transition: all 0.5s ease-in-out 0s;
    }
    .export-btn:active {
        color: #ffffff !important;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {

        $(document).on('click', '#barcode_file_list', function () {
            $.ajax({
                url: '/product/manage/barcodeFileList',
                type: 'post',
                dataType: 'json',
                data: {data: 'data'},
                success: function (response) {
                    $('#file_list').html('');
                    var html_f_list = '';
                    response.forEach(function (v) {
                        html_f_list += '<a href="/product/manage/downloadBarcode?barcode='+v+'">'+v+'</a><br />';
                    });
                    $('#file_list').html(html_f_list);
                    $('#file_list').show();
                },
                error: function (e) {
                    console.log(e);
                }
            });
        });

    });
</script>
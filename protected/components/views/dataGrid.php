
<!--<link rel="stylesheet" type="text/css" href="../DataGrid/themes/bootstrap/easyui.css">-->
<!--<link rel="stylesheet" type="text/css" href="../DataGrid/themes/icon.css">-->
<!--<link rel="stylesheet" type="text/css" href="../demo.css">-->
<!--        <script type="text/javascript" src="../../jquery.min.js"></script>-->


<?php
Yii::app()->clientScript->registerCoreScript('jquery');
$baseUrl = Yii::app()->request->getBaseUrl(true);
$cs = Yii::app()->getClientScript();

$cs->registerCssFile($baseUrl . '/js/datagrid/themes/bootstrap/easyui.css');
$cs->registerCssFile($baseUrl . '/js/datagrid/themes/icon.css');

$cs->registerScriptFile($baseUrl . '/js/datagrid/jquery.easyui.min.js', CClientScript::POS_HEAD);
$cs->registerScriptFile($baseUrl . '/js/datagrid/filter/datagrid-filter.js', CClientScript::POS_HEAD);
?>

<div style="width: 90%">

    <table id="dg" title="Client Side Pagination" style="width:80%; height:350px;" data-options="
           rownumbers:true,
           singleSelect:true,
           autoRowHeight:false,
           striped:true,
           pagination:<?php echo $this->enablePagination; ?>,
           pageSize:<?php echo $this->pageSize; ?>" url="<?php echo $this->url; ?>" >
        <thead>
            <tr>
                <?php foreach ($this->headers as $key => $val) { ?>
                    <?php if (isset($val['label']) && !empty($val['label'])) { ?>
                        <th field="<?php echo $key; ?>" <?php
                        echo (implode(' ', array_map(function($key) use ($val) {
                                    return $key . '=' . '"' . $val[$key] . '"';
                                }, array_keys($val))));
                        ?> ><?php echo $val['label']; ?></th>
                        <?php } ?>
                    <?php } ?>
            </tr>
        </thead>
    </table>
</div>
<script>

    function getData() {
        var rows = [];
        rows = <?php echo json_encode($this->rows); ?>;
        return rows;
    }

    $(function () {
        var dg = $('#dg').datagrid({
            data: getData(),
            onLoadSuccess: function () {
                $(this).datagrid('enableFilter');
            }
        });
        dg.datagrid('getPager').pagination({
            layout: ['first', 'prev', 'links', 'next', 'last', 'refresh']
        });



    });

//    $(function () {
//        $('#dg').datagrid('enableFilter');
//    });
</script>

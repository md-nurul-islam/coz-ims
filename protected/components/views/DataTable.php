<?php
Yii::app()->clientScript->registerCoreScript('jquery');
$baseUrl = Yii::app()->request->getBaseUrl(true);
$cs = Yii::app()->getClientScript();

$cs->registerCssFile($baseUrl . '/js/datatable/themes/dataTables.bootstrap.css');

$cs->registerScriptFile($baseUrl . '/js/datatable/jquery.dataTables.min.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/datatable/dataTables.bootstrap.min.js', CClientScript::POS_END);
?>

<input type="hidden" name="datatable_filter_url" id="datatable_filter_url" value="<?php echo "{$this->getDataSource()}"; ?>" />

<?php
$class = 'display table table-bordered table-condensed table-striped table-hover';
$selector_sign = '#';
if ($this->getInitiateBy() === 'class') {
    $class .= " {$this->getSelector()}";
    $selector_sign = '.';
}
?>

<table
<?php
if ($this->getInitiateBy() !== 'class') {
    echo "{$this->getInitiateBy()}={$this->getSelector()}";
}
?>
    class="<?php echo $class; ?>" cellspacing="0" width="100%">
        <?php echo $this->getStrHeader(); ?>
        <?php if ($this->hasFooter) echo $this->getStrFooter(); ?>

</table>

<script type="text/javascript">

    $(document).ready(function () {
        var table_to_be_selected = '<?php echo "{$selector_sign}{$this->getSelector()}"; ?>';
        var id_column = '<?php echo $this->getColumnId(); ?>';
        var oTable = $(table_to_be_selected).dataTable(
            <?php echo $this->getConfiguration(); ?>
        );

        if ($('form#datatable_filter').length > 0) {

            $('form#datatable_filter').submit(function (e) {
                e.preventDefault();
                var formData = processForm($(this).attr('id'));
                oTable.fnFilter(JSON.stringify(formData));
            });
        }

        <?php if ($this->showModal) { ?>
            $(table_to_be_selected + ' tbody').on('click', 'tr', function () {
                var position = oTable.fnGetPosition(this);
                var row = oTable.fnGetData(position);
                var row_id = row[id_column];

                if (row_id !== undefined) {
                    var modal_selector = '<?php echo $this->modalSelector; ?>';
                    var data_source = '<?php echo $this->modalDataSource; ?>';

                    $.ajax({
                        url: data_source + '/' + row_id,
                        type: 'post',
                        data: {'row_id': row_id, formData: JSON.stringify(processForm('datatable_filter'))},
                    }).done(function (data, textStatus) {
                        $(modal_selector).html(data);
                        $(modal_selector).modal('show');
                    }).fail(function (xhr, textStatus, errorThrown) {
                        console.log(textStatus);
                    });
                }
                return false;
            });
        <?php } ?>


        function processForm(formId) {
            var formData = {};
            $.each($('form#' + formId).serializeArray(), function () {
                formData[this.name] = this.value;
            });
            return formData;
        }

    });

</script>

<style type="text/css">
    table.dataTable tbody tr {
        cursor: pointer;
    }
    table.dataTable thead th {
        background-color: transparent;
    }
    table.dataTable th:first-child, table.dataTable td:first-child {
        text-align: left;
    }
    table.dataTable th, table.dataTable td {
        padding: 7px 10px;
    }
    .dataTables_paginate {
        float: right;
    }
    ul.pagination {
        margin-top: 10px;
        width: 100%;
    }
    ul.pagination .paginate_button {
        border: 0.5px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
        display: inline;
        margin: 5px;
        padding: 10px;
    }
    ul.pagination .paginate_button a {
        text-decoration: none;
        width: 100%;
    }
    ul.pagination .active {
        background-color: #06c;
    }
    ul.pagination .active > a {
        color: #fff;
    }
    #datatable_previous {

    }
    #datatable_previous a {

    }
    #datatable_next {

    }
    #datatable_next a {

    }

</style>
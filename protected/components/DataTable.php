<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DataTable extends CWidget {

    public $model;
    public $hasFooter = false;
    public $ajax = true;
    public $lengthChange = false;
    public $defaultFilter = false;
    public $columnDefs = [];
    public $pageLength = 100;
    public $columnId = 'id';
    public $showModal = true;
    public $modalSelector = '#myModal';
    public $modalDataSource = '';
    public $dataSource;
    public $request_type = 'post';
    public $deferRender = true;
    public $header;
    public $footer;
    public $initiateBy = 'id';
    public $selector = 'datatable';
    public $columns = '';
    public $footerCallback = false;

    /** PRIVATE * */
    private $_errors = [];

    public function init() {

        $model = new $this->model;
        $this->validateDataTable();
    }

    public function run() {
//        $this->set_widget_path(strtolower(get_called_class()));
//        $this->init($params);
//        $this->render($params, 'DataTable');
        $this->render('DataTable');
    }

    public function getColumnId() {
        return $this->columnId;
    }

    public function getDataSource() {
        return $this->dataSource;
    }

    public function getRequestType() {
        return $this->request_type;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getConfiguration() {

        $config = [];

        if ($this->ajax) {
            $config['processing'] = 'true';
            $config['serverSide'] = 'true';
            $config['ajax']['url'] = $this->dataSource;
            $config['ajax']['type'] = $this->getRequestType();
        }

        if (!$this->defaultFilter) {
            $config['sDom'] = '<"top"i>rt<"bottom"p><"clear">';
        }

        $config['deferRender'] = ($this->deferRender);
        $config['bLengthChange'] = ($this->lengthChange);
        if (!empty($this->columnDefs)) {
            $config['columnDefs'] = $this->columnDefs;
        }

        $config['columns'] = $this->getColumns();
        $config['pageLength'] = $this->pageLength;

        return json_encode($config);
    }

    /**
     * @param array $header/$footer
     * @return string Header or Footer Cells (<th>cell</th>)
     * Description: Header and Footer are the fixed rows.
     * * */
    public function prepareFixedRow($param) {
        $row_open = '<tr>';
        $row_close = '</tr>';

        $cells = implode('', array_map(function($header) {
                    return "<th>{$header}</th>";
                }, $param));
        return "{$row_open}{$cells}{$row_close}";
    }

    /**
     * @param array $datatable
     * @return boolean
     * Description: Validates Datatable structure
     * * */
    public function validateDataTable() {

        if (!$this->validHeader()) {
            $this->setError('invalid_header', 'Header empty or not present.', 'error');
        }

        if (!$this->validFooter()) {
            $this->setError('invalid_footer', 'Footer empty or not present.');
        } else {
            $this->hasFooter = TRUE;
        }
    }

    public function setError($key, $value, $level = 'notice') {
        $this->_errors[$key]['message'] = $value;
        $this->_errors[$key]['level'] = $level;
        return $this;
    }

    public function getError($key = '') {
        return (!empty($key)) ? $this->_errors[$key] : $this->_errors;
    }

    public function getHeader() {
        return $this->header;
    }

    public function getStrHeader() {
        return "<thead>{$this->prepareFixedRow($this->header)}</thead>";
    }

    public function getFooter() {
        return $this->footer;
    }

    public function getStrFooter() {
        return "<tfoot>{$this->prepareFixedRow($this->footer)}</tfoot>";
    }

    public function getInitiateBy() {
        return $this->initiateBy;
    }

    public function getSelector() {
        return $this->selector;
    }

    /**
     * @param array $headers
     * @return boolean
     * Description: Validates datatable header structure
     * * */
    private function validHeader() {
        return !empty($this->header);
    }

    /**
     * @param array $footer
     * @return boolean
     * Description: Validates datatable footer structure
     * * */
    private function validFooter() {
        return !empty($this->footer);
    }

}

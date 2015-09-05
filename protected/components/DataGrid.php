<?php

//Yii::import('zii.widgets.CPortlet');

class DataGrid extends CWidget {

    public $model;
    public $headers = array();
    public $rows = array();
    public $enableFilter = true;
    public $enablePagination = true;
    public $pageSize;
    public $numTotalRows;
    public $module = '';
    public $controller = '';
    public $action = '';
    public $url = '';

    public function init() {
        $this->model = new $this->model;
        $this->setHeaders();
        $this->setPageSize();
        $this->setFilter();
        $this->setPagination();
        $this->setController();
        $this->setAction();
        $this->setUrl();
        $this->setRows();
    }

    public function run() {
//        var_dump($this->rows);
//        exit;
        $this->render('dataGrid');
    }

    private function setHeaders() {
        if (empty($this->headers)) {
            $this->headers = $this->model->dataGridHeaders();
        }
    }

    private function setRows() {
        if (empty($this->rows)) {
            $this->rows = $this->model->dataGridRows();
        }
    }

    private function setPageSize() {
        if ($this->pageSize > 0) {
            $this->pageSize = $this->pageSize;
            $this->model->pageSize = $this->pageSize;
        }
        elseif ($this->model->pageSize > 0) {
            $this->pageSize = $this->model->pageSize;
        } else {
            $this->pageSize = 10;
        }        
    }

    private function setFilter() {
        if (!empty($this->enableFilter)) {
            $this->enableFilter = $this->enableFilter;
        }
        $this->enableFilter = ($this->enableFilter) ? 'true' : 'false';
    }

    private function setPagination() {
        if (!empty($this->enablePagination)) {
            $this->enablePagination = $this->enablePagination;
        }
        $this->enablePagination = ($this->enablePagination) ? 'true' : 'false';
    }

    private function setController() {
        $this->controller = (!empty($this->controller)) ? $this->controller : Yii::app()->controller->id;
    }

    private function setAction() {
        $this->action = (!empty($this->action)) ? $this->action : Yii::app()->controller->action->id;
    }

    private function setUrl() {
        $this->url = '/';
        $this->url .= (!empty($this->module)) ? $this->module . '/' : $this->controller . '/' . $this->action;
    }

}
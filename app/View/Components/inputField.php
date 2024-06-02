<?php

namespace App\View\Components;

use Illuminate\View\Component;

class inputField extends Component
{
    public $cols;
    public $divID;
    public $column;
    public $model;
    public $optional;
    public $inputType;
    public $className;
    public $columnID;
    public $columnValue;
    public $attribute;
    public $readonly;

    public function __construct($cols, $column, $model, $optional = '', $inputType = 'text', $className = '', $columnID = '', $columnValue = '', $attribute = '', $readonly = '', $divID = '')
    {
        $this->cols = $cols;
        $this->column = $column;
        $this->model = $model;
        $this->optional = $optional;
        $this->inputType = $inputType;
        $this->className = $className;
        $this->columnID = $columnID;
        $this->columnValue = $columnValue;
        $this->attribute = $attribute;
        $this->readonly = $readonly;
        $this->divID = $divID;
    }

    public function render()
    {
        return view('components.input-field');
    }
}

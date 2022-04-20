<?php

// Class for storing info about input field on the form
class InputInfo {
    public $type;
    public $name;
    public $value;
    public $id;

    public function __construct($type, $name, $value, $id) {
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->id = $id;
    }
}

// Class for build the form in web page
class FormBuilder {
    private $method;
    private $target;
    private $submit_value;

    private $inputTags = array();

    public function __construct($method, $target, $submit_value) {
        $this->method = $method;
        $this->target = $target;
        $this->submit_value = $submit_value;
    }

    public function addTextField($name, $ids, $values) {
        if (count($values) == count($ids)) {
            $len = count($values);
            for ($i = 0; $i < $len; $i++) {
                $inputForm = new InputInfo("text", $name, $values[$i], $ids[$i]);
                $this->inputTags[] = $inputForm;
            }
        }
    }

    public function addRadioGroup($name, $ids, $values) {
        if (count($values) == count($ids)) {
            $len = count($values);
            for ($i = 0; $i < $len; $i++) {
                $inputForm = new InputInfo("radio", $name, $values[$i], $ids[$i]);
                $this->inputTags[] = $inputForm;
            }
        }
    }

    public function addCheckboxGroup($name, $ids, $values) {
        if (count($values) == count($ids)) {
            $len = count($values);
            for ($i = 0; $i < $len; $i++) {
                $inputForm = new InputInfo("checkbox", $name, $values[$i], $ids[$i]);
                $this->inputTags[] = $inputForm;
            }
        }
    }

    // form output
    public function getForm() : string {
        $form_str = "<form target='$this->target' method='$this->method'>";
        foreach ($this->inputTags as $value) {
            if (strcmp($value->type, "text") === 0) {
                $form_str .= "<input type='$value->type' name='$value->name' value='$value->value' id='$value->id'> <br />";
            }
            else {
                $form_str .= "<input type='$value->type' name='$value->name' value='$value->value' id='$value->id'>";
                $form_str .= "<label for='$value->id'> $value->value </label> <br/>";
            }
        }
        $form_str .= "<input type='submit' value='$this->submit_value'>";
        $form_str .= "</form>";

        return $form_str;
    }
}


// Creating the form
$formBuilder = new FormBuilder("get", '12.php', 'send');
$formBuilder->addTextField("test", ["sm11", "sm12"], ["someValue2", "someValue1"]);
$formBuilder->addRadioGroup("radio group", ["a", "b", "c"], ["A", "B", "C"]);
$formBuilder->addCheckboxGroup("check box group", ["1", "2", "3"], ["a1", "a2", "a3"]);
echo $formBuilder->getForm();

<?php

namespace classes;

use Exception;
class Validation
{
    private $passed = false,
        $errors;

    public function checkUserInput($src, $items)
    {
        foreach ($items as $item => $rules) {
            foreach ($rules as $rule => $rule_value){
                $value = $this->escape($src[$item]);
                if ($rule === 'required' && empty($value)){
                    $this->addError("{$rules['ruleName']} er påkrevd");
                }
                else if (!empty($value)){
                    $this->verifyUserInfo($src, $rules, $rule, $rule_value, $value);
                }
            }
        }
        if (empty($this->errors)){
            $this->passed = true;
        }
        return $this;
    }
    private function verifyUserInfo($src, $rules, $rule, $rule_value, $value){
        try
        {
            switch ($rule)
            {
                case "min":
                    if (strlen($value) < $rule_value)
                    {
                        $this->addError("{$rules['ruleName']} må inneholde minst {$rule_value} bokstaver");
                    }
                    break;
                case "max":
                    if (strlen($value) > $rule_value)
                    {
                        $this->addError("{$rules['ruleName']} kan inneholde maksimum {$rule_value} bokstaver");
                    }
                    break;
                case "emailVerify":
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL))
                    {
                        $this->addError("Ugyldig epostadresse");
                    }
                    break;
            }
        } catch (Exception $e) {
            echo "<p>Det skjedde en feil. Vennligst prøv igjen senere . $e .</p>";
        }
    }
    public function escape($input)
    {
        $input = trim($input);
        return $input;
    }
    private function addError($error)
    {
        $this->errors[] = $error;
    }
    public function getPassed()
    {
        return $this->passed;
    }
    public function getErrors()
    {
        return $this->errors;
    }
}
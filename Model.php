<?php


namespace jddev2381\phpmvc;



/**
 * Class Model
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc
 */


abstract class Model {

    public const RULE_REQUIRED  = 'required';
    public const RULE_EMAIL     = 'email';
    public const RULE_MIN       = 'min';
    public const RULE_MAX       = 'max';
    public const RULE_MATCH     = 'match';
    public const RULE_UNIQUE    = 'unique';

    public array $errors = [];


    public function loadData($data) {
        foreach($data as $key => $value) {
            if(property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    // Must be implemented in child class
    abstract public function rules(): array;

    // Get user friendly "Labels" to use as labels to fields or placeholder text
    public function labels(): array {
        return [];
    }

    public function getLabel($attribute) {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function validate() {
        foreach($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach($rules as $rule) {
                $ruleName = $rule;
                if(is_array($ruleName)) {
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MIN, $rule);
                }
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAX, $rule);
                }
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $rule['match'] = $this->getLabel($rule['match']);
                    $this->addErrorForRule($attribute, self::RULE_MATCH, $rule);
                }
                if($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->pdo->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $result = $statement->fetchObject();
                    if($result) {
                        $this->addErrorForRule($attribute, self::RULE_UNIQUE, ['field' => $this->getLabel($attribute)]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    public function addError(string $attribute, string $message) {
        
    }


    private function addErrorForRule($attribute, $rule, $params = []) {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages() {
        return [
            self::RULE_REQUIRED => 'This field is required.',
            self::RULE_EMAIL => 'Must be a valid email address.',
            self::RULE_MIN => 'Must be {min} characters.',
            self::RULE_MAX => 'Must not be more than {max} characters.',
            self::RULE_MATCH => 'This field must match the {match} field.',
            self::RULE_UNIQUE => 'A record with this {field} already exists.',
        ];
    }

    public function hasErrors($attribute) {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute) {
        return $this->errors[$attribute][0] ?? false;
    }


}
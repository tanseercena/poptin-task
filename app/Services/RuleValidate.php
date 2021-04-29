<?php

namespace App\Services;

class RuleValidate
{
    private $conditions;

    private $url;

    public static function fromCondition($conditions)
    {
        return new static($conditions);
    }

    public function __construct($conditions)
    {
        $this->conditions = $conditions;
    }

    public function validate($url) {
        $this->url = ltrim($url, "/");

        $check_contains = $this->validateContainsRule();

        $check_start = $this->validateStartRule();

        $check_end = $this->validateEndRule();

        $check_exact = $this->validateExactRule();

        return ($check_contains || $check_start || $check_end || $check_exact);
    }

    private function validateContainsRule() {
        $rules = $this->conditions->where("rule", 'contains');

        if($rules->isEmpty())
            return false;

        $url = $this->url;

        return $rules->contains(function ($rule, $key) use($url) {
            return strpos($url, $rule->rule_txt) !== false;
        });
    }

    private function validateStartRule() {
        $rules = $this->conditions->where("rule", 'start');

        if($rules->isEmpty())
            return false;

        $url = $this->url;

        return $rules->contains(function ($rule, $key) use($url) {
            return strncmp($url, $rule->rule_txt, strlen($rule->rule_txt)) === 0;
        });
    }

    private function validateEndRule() {
        $rules = $this->conditions->where("rule", 'ends');

        if($rules->isEmpty())
            return false;

        $url = $this->url;

        return $rules->contains(function ($rule, $key) use($url) {
            return $rule->rule_txt === "" || (substr($url, -strlen($rule->rule_txt)) === $rule->rule_txt);
        });
    }

    private function validateExactRule() {
        $rules = $this->conditions->where("rule", 'exact');

        if($rules->isEmpty())
            return false;

        $url = $this->url;

        return $rules->contains(function ($rule, $key) use($url) {
            return $rule->rule_txt == $url;
        });
    }

}

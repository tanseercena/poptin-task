<?php

namespace App\Services;

use App\Models\Rule;

class RuleService
{
    private $rule;

    private $conditions;

    public static function fromRule(Rule $rule)
    {
        return new static($rule);
    }

    public function __construct(Rule $rule)
    {
        $this->rule = $rule;
        $this->conditions = $this->rule->conditions;
    }

    public function checkUrlConditions($url) {
        $check_dont = $this->checkDontShow($url);

        if($check_dont) {
            return false;
        }

        return $this->checkShow($url);
    }

    private function checkDontShow($url) {
        $dont_show_conditions = $this->conditions->where("show",0);
        return RuleValidate::fromCondition($dont_show_conditions)->validate($url);
    }

    private function checkShow($url) {
        $show_conditions = $this->conditions->where("show",1);
        return RuleValidate::fromCondition($show_conditions)->validate($url);
    }

}

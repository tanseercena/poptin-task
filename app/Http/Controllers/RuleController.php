<?php

namespace App\Http\Controllers;

use App\Http\Requests\RuleRequest;
use App\Models\Rule;
use App\Services\RuleService;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index()
    {
        return response()->json(Rule::where("user_id", auth()->user()->id)->with("conditions")->get());
    }

    public function save(RuleRequest $request)
    {
        $rule = Rule::create([
            'alert_text' => $request->alert_text,
            'user_id' => auth()->user()->id
        ]);

        $rule->conditions()->createMany($request->conditions);

        $data = [
            'message' => 'Rule has been created',
            'rules' => Rule::where("user_id", auth()->user()->id)->with("conditions")->get()
        ];

        return response()->json($data, 201);
    }

    public function delete(Rule $rule) {
        $rule->conditions()->delete();

        if($rule->delete()) {
            $data = [
                'message' => 'Rule has been deleted',
                'rules' => Rule::where("user_id", auth()->user()->id)->with("conditions")->get()
            ];

            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Rule not deleted',
            'rules' => Rule::where("user_id", auth()->user()->id)->with("conditions")->get()
        ];

        return response()->json($data, 200);
    }

    public function checkRuleCondition(Request $request, Rule $rule) {
        $check = RuleService::fromRule($rule)->checkUrlConditions($request->url);

        return response()->json(['show' => $check, 'text' => $rule->alert_text]);
    }
}

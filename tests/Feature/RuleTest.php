<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RuleTest extends TestCase
{
    /**
     * It does not create a rule.
     *
     * @return void
     */
    public function test_it_does_not_create_a_rule()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user,'api')->postJson('/api/rules', []);

        $response->assertStatus(422);
    }

    /**
     * It can create a rule.
     *
     * @return void
     */
    public function test_it_can_create_a_rule()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user,'api')->postJson('/api/rules', [
            'alert_text' => 'Test',
            'conditions' => [
                [
                    'show' => 1,
                    'rule' => 'contains',
                    'rule_txt' => 'testing'
                ]
            ]
        ]);

        $response->assertStatus(201)->assertJson(['message' => 'Rule has been created']);
    }
}

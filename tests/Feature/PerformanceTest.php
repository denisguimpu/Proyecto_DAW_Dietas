<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class PerformanceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Comprueba que la página de inicio responda en menos de 2 segundos.
     */
    public function test_home_page_response_time_is_under_two_seconds()
    {
        $start = microtime(true);
        $response = $this->get('/');
        $end = microtime(true);
        
        $duration = $end - $start;
        
        $this->assertLessThan(2.0, $duration, "La página de inicio tardó {$duration} segundos, superando el límite de 2.");
        $response->assertStatus(200);
    }

    /**
     * Comprueba que el panel de planes de comida responda rápido para un usuario autenticado.
     */
    public function test_meal_plans_index_response_time_is_under_two_seconds()
    {
        $user = User::factory()->create();
        
        $start = microtime(true);
        $response = $this->actingAs($user)->get('/meal-plans');
        $end = microtime(true);
        
        $duration = $end - $start;
        
        $this->assertLessThan(2.0, $duration, "El índice de planes de comida tardó {$duration} segundos.");
        $response->assertStatus(200);
    }
}

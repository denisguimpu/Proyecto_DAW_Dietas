<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Simulación de prueba de rendimiento para rutas críticas.
     * Verifica que el tiempo de respuesta sea aceptable bajo una carga ligera simulada.
     */
    public function test_critical_routes_performance_baseline()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $routes = [
            '/dashboard',
            '/shopping-lists',
            '/menus',
            '/ingredients',
        ];

        foreach ($routes as $route) {
            $start = microtime(true);
            $response = $this->get($route);
            $end = microtime(true);
            
            $duration = ($end - $start) * 1000; // ms
            
            $response->assertStatus(200);
            
            // Un baseline razonable para entorno local es < 500ms
            $this->assertLessThan(500, $duration, "La ruta {$route} es demasiado lenta: {$duration}ms");
        }
    }

    /**
     * Prueba de "carga" simulada: Ejecutar múltiples peticiones secuenciales 
     * y verificar que el sistema no se degrade significativamente.
     */
    public function test_sequential_load_stability()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $iterations = 10;
        $times = [];

        for ($i = 0; $i < $iterations; $i++) {
            $start = microtime(true);
            $this->get('/dashboard');
            $times[] = (microtime(true) - $start) * 1000;
        }

        $averageTime = array_sum($times) / count($times);
        
        // Verificamos que la media sea saludable
        $this->assertLessThan(300, $averageTime, "El tiempo medio de respuesta en carga secuencial es alto: {$averageTime}ms");
    }
}

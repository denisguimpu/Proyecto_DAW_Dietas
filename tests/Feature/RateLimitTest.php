<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verificar que el login tiene limitación de intentos (Rate Limiting).
     */
    public function test_login_has_rate_limiting()
    {
        $user = User::factory()->create();
        
        // Simulamos 6 intentos fallidos (el límite estándar suele ser 5 o 6 por minuto)
        for ($i = 0; $i < 7; $i++) {
            $response = $this->post('/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);
        }

        // El último intento debería devolver 429 (Too Many Requests) o contener el error de throttle en la sesión
        // Dependiendo de cómo esté implementado en Breeze, puede redirigir con errores.
        $response->assertSessionHasErrors('email');
        
        // Verificamos si el mensaje indica que hay demasiados intentos
        $errors = session('errors')->get('email');
        $this->assertTrue(collect($errors)->contains(fn($msg) => str_contains($msg, 'intentos') || str_contains($msg, 'seconds')));
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ingredient;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que los usuarios no autenticados sean redirigidos al login en rutas protegidas.
     */
    public function test_guest_cannot_access_protected_routes()
    {
        $protectedRoutes = [
            '/menus',
            '/ingredients',
            '/diets',
            '/meal-plans',
            '/shopping-lists',
            '/profile',
        ];

        foreach ($protectedRoutes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/login');
        }
    }

    /**
     * Test de protección contra inyección básica en parámetros.
     */
    public function test_sql_injection_protection()
    {
        $user = User::factory()->create();
        
        $injectionPayload = "Manzana' OR '1'='1";
        
        // Usamos withSession para saltar CSRF en el test de inyección si fuera necesario,
        // o simplemente enviamos el token esperado por Laravel en modo test.
        $response = $this->actingAs($user)
            ->post('/ingredients', [
                'name' => $injectionPayload,
                'kcal' => 50,
                'gr_ration' => 100,
                'protein' => 0,
                'carbs' => 0,
                'fats' => 0
            ]);

        // Verificamos que se guardó el payload literal, no que se ejecutó la inyección
        $this->assertDatabaseHas('ingredients', [
            'name' => $injectionPayload
        ]);
        
        $response->assertRedirect(route('ingredients.index'));
    }

    /**
     * Test de que no se puede acceder a datos de otros usuarios (si los hubiera).
     * Nota: En este proyecto las dietas/ingredientes parecen ser globales o compartidos,
     * pero el perfil es privado.
     */
    public function test_user_cannot_access_other_user_profile_data()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Intentar acceder al perfil siendo otro usuario
        $response = $this->actingAs($user1)->get('/profile');
        $response->assertStatus(200);
        $response->assertSee($user1->email);
        $response->assertDontSee($user2->email);
    }
}

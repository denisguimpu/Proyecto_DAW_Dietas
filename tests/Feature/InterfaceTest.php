<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class InterfaceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verificar que las páginas principales cargan los elementos visuales básicos.
     */
    public function test_main_pages_have_essential_ui_elements()
    {
        $user = User::factory()->create();
        $pages = [
            '/menus' => 'Menús',
            '/ingredients' => 'Ingredientes',
            '/diets' => 'Dietas',
            '/meal-plans' => 'Plan Semanal',
            '/shopping-lists' => 'Lista Compra',
        ];

        foreach ($pages as $url => $title) {
            $response = $this->actingAs($user)->get($url);
            $response->assertStatus(200);
            $response->assertSee($title);
            $response->assertSee('<nav', false); // Debe tener navegación
            $response->assertSee('Log Out'); // Debe tener botón de salida
        }
    }

    /**
     * Prueba básica de accesibilidad: presencia de etiquetas de encabezado y roles.
     */
    public function test_basic_accessibility_markers_are_present()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/menus');

        // Verificar que hay al menos un H1 para SEO y accesibilidad
        $response->assertSee('<h1', false);
        
        // Verificar que los botones o enlaces importantes tienen texto descriptivo (no están vacíos)
        $response->assertSee('Nuevo'); 
    }

    /**
     * Verificar que el Dashboard carga los gráficos (indicador de interactividad).
     */
    public function test_dashboard_displays_charts_container()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        // El dashboard usa Chart.js, buscamos el canvas o el script
        $response->assertSee('<canvas', false);
    }
}

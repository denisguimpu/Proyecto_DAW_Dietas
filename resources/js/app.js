/**
 * APP.JS - PUNTO DE ENTRADA DE JAVASCRIPT
 * =================================
 * 
 * Este archivo es el punto de entrada principal del JavaScript en el frontend.
 * Se ejecuta cuando se carga la página en el navegador.
 * 
 * Aquí importamos:
 * - boostrap.js: Configuración básica para HTTP requests
 * - Alpine.js: Librería para interactividad (comentada por ahora)
 */

// ============================================================================
// IMPORTS
// ============================================================================

// Importamos boostrap.js que:
// - Configura axios para hacer peticiones HTTP
// - Añade headers automáticos a todas las peticiones
import './bootstrap';

// Alpine.js es una librería ligera para hacer las páginas interactivas
// sin escribir JavaScript complejo. Es como Vue.js pero más simple.
// Currently commented out because we're not using it in this project.
//import Alpine from 'alpinejs';

// Configuramos Alpine globalmente para que esté disponible en window
//window.Alpine = Alpine;

// Arrancamos Alpine (solo si lo usamos)
//Alpine.start();

/**
 * BOOTSTRAP.JS - CONFIGURACIÓN DE HTTP
 * ================================
 * 
 * Este archivo configura cómo hacemos peticiones HTTP desde JavaScript.
 * Usa "axios" que es una librerías para hacer peticiones AJAX (sin recargar).
 * 
 * AJAX = Asynchronous JavaScript And XML
 * Es una técnica para pedir datos al servidor sin recargar la página.
 * Por ejemplo: cuando vas escribiendo y aparecen sugerencias, es AJAX.
 */

// ============================================================================
// IMPORT DE AXIOS
// ============================================================================
// Axios es una librería que simplifica hacer peticiones HTTP.
// Es más fácil que usarfetch() nativo de JavaScript.
// Ejemplo: await axios.get('/api/user') vs fetch('/api/user')

import axios from 'axios';

// Hacemos axios disponible globalmente en window
// Así podemos usar axios() en cualquier lugar del código
window.axios = axios;

// ============================================================================
// CONFIGURACIÓN POR DEFECTO
// ============================================================================
// Headers son información extra que mandamos con cada petición.
// X-Requested-With = XMLHttpRequest le dice al servidor que es una petición AJAX.
// Esto es útil porque el servidor puede devolver JSON en lugar de redireccionar.
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/* 
 * RESUMEN DE LO QUE HACE ESTE ARCHIVO:
 * 
 * 1. Importa la librería axios
 * 2. La hace disponible como window.axios
 * 3. Añade un header por defecto a todas las peticiones
 * 
 * Ahora, cuando hacemos axios.get('/algo'), automáticamente incluye:
 * X-Requested-With: XMLHttpRequest
 */

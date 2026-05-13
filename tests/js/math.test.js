// tests/js/math.test.js

// Importaremos la función cuando exista, por ahora probamos el entorno
// import { sumar } from '../../resources/js/utils/math.js';

describe('Pruebas de ejemplo con Jest', () => {
    test('La suma básica funciona correctamente', () => {
        const resultado = 2 + 2;
        expect(resultado).toBe(4);
    });

    test('Verificación de texto', () => {
        const texto = 'Dietas';
        expect(texto).toMatch(/Dietas/);
        expect(texto).not.toBeNull();
    });
});

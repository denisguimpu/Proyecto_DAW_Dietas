# Cómo Poblar la Base de Datos (Seeders)

Esta guía explica paso a paso cómo poblar la base de datos con datos iniciales y cómo compartir este proceso con los demás miembros del equipo.

## 1. Crear el Seeder

La persona encargada de subir los datos iniciales debe ejecutar el siguiente comando en su terminal para crear un nuevo Seeder:

```bash
php artisan make:seeder IngredientSeeder
```

## 2. Meter los datos en el archivo

El comando anterior habrá creado un archivo en `database/seeders/IngredientSeeder.php`. Debes abrir este archivo y editar el método `run` de la siguiente manera:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient; // Es importante importar el modelo correspondiente

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        $ingredients = [
            ['name' => 'Pechuga de Pollo', 'calories' => 165, 'protein' => 31, 'carbs' => 0, 'fats' => 3.6],
            ['name' => 'Arroz Integral', 'calories' => 111, 'protein' => 2.6, 'carbs' => 23, 'fats' => 0.9],
            ['name' => 'Huevo', 'calories' => 155, 'protein' => 13, 'carbs' => 1.1, 'fats' => 11],
            // ... mete aquí todos los datos que quieras añadir
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create($ingredient);
        }
    }
}
```

## 3. Registrar el Seeder

Abre el archivo `database/seeders/DatabaseSeeder.php` y añade la llamada a tu nuevo Seeder dentro del método `run`:

```php
    public function run(): void
    {
        $this->call([
            IngredientSeeder::class,
        ]);
    }
```

## 4. ¿Cómo lo reciben los demás? (El flujo de trabajo)

* **Tú (el que ha escrito los datos):** Subes los cambios a GitHub (específicamente los archivos `IngredientSeeder.php` y `DatabaseSeeder.php`).
* **Tus compañeros:** Hacen un `git pull` para bajar los cambios a sus equipos locales.
* **Todos:** Ejecutan el siguiente comando en su terminal:

```bash
php artisan db:seed
```

**¡Magia!** Al ejecutar ese comando, Laravel lee tu lista de datos y la inserta automáticamente en la base de datos local de cada desarrollador.

## ¿Y si ya tenemos datos y queremos limpiar y empezar de cero?

Si necesitáis borrar los datos actuales en vuestras bases de datos locales y que queden exactamente como están definidos en los Seeders, utilizad el siguiente comando:

```bash
php artisan migrate:fresh --seed
```

> [!WARNING]  
> **Cuidado:** Esto borra **todas las tablas** y las vuelve a crear vacías antes de meter los datos definidos en los Seeders. Úsalo solo en entornos de desarrollo y cuando estés seguro de que no perderás datos importantes.

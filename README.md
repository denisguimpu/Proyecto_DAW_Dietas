🚀 Proyecto TFG: App de Dietas y Nutrición
Bienvenido al repositorio del proyecto. Este proyecto está desarrollado utilizando Laravel (PHP 8.2) para agilizar el desarrollo, facilitando la gestión de lógica (Backend) y vistas (Frontend) sin configuraciones complejas.

🛠 Stack Tecnológico
Framework: Laravel 10/11

Lenguaje: PHP 8.2

Base de Datos: MySQL (XAMPP/WAMP)

Frontend: Blade (Motor de plantillas de Laravel) + Bootstrap 5 (CDN)

⚙️ Configuración Inicial (Para el equipo)
Para que el proyecto funcione en tu máquina, sigue estos pasos:

Clonar el repo: ``` git clone <URL_DEL_REPOSITORIO>```

Instalar xampp 8.2.12: https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.12/xampp-windows-x64-8.2.12-0-VS16-installer.exe

Instalar dependencias:
``` bash
composer install
npm install
```

Configurar entorno:

Copia el archivo .env.example y renómbralo a .env.

Abre el .env y ajusta la conexión a tu base de datos local:

Fragmento de código
DB_DATABASE=dieta_tfg
DB_USERNAME=root
DB_PASSWORD=
Generar key: ``` php artisan key:generate```

Preparar Base de Datos:

Crea una base de datos vacía en phpMyAdmin llamada dieta_tfg.

Ejecuta: php artisan migrate

Ejecutar el entorno:

Terminal 1:```npm run dev```

Terminal 2: ```php artisan serve```

📂 Estructura del Proyecto (¿Dónde está cada cosa?)
Para que sepáis dónde tocar código:

routes/web.php: Aquí definimos las URLs (ej. /ingredients).

app/Http/Controllers/: Lógica del Backend. Aquí se procesan los datos antes de enviarlos a la vista.

app/Models/: Conexión a BD. Define los campos de las tablas (ej. Ingredient.php).

database/migrations/: Estructura BD. Aquí están los archivos que crean las tablas al hacer migrate.

resources/views/: Frontend (HTML/Blade). Aquí está el diseño de la web.

ingredients/index.blade.php: Tabla principal de alimentos.

ingredients/create.blade.php: Formulario para añadir datos.

📝 División de Tareas
Backend: Controladores, modelos y lógica de cálculo.

Frontend: Maquetación con Blade y diseño responsive con Bootstrap 5.

Base de Datos: Gestión mediante migraciones (no compartir archivos .sql manuales).

¿Cómo añadir datos de prueba?
Si quieres llenar la tabla de ingredientes automáticamente, ejecuta:
php artisan db:seed
(Nota: Asegúrate de tener configurado el archivo IngredientSeeder en database/seeders/).
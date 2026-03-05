<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Lista de Alimentos</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4 text-primary">Lista de Ingredientes</h1>
        
        <div class="table-responsive">
            <table class="table table-hover table-striped shadow-sm bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Calorías</th>
                        <th>Proteínas</th>
                        <th>Grasas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ingredients as $ingredient)
                    <tr>
                        <td><strong>{{ $ingredient->name }}</strong></td>
                        <td>{{ $ingredient->calories }} kcal</td>
                        <td>{{ $ingredient->protein }}g</td>
                        <td>{{ $ingredient->fats }}g</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
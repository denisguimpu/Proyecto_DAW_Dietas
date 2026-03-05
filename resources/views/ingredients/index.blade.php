<!DOCTYPE html>
<html>
<head>
    <title>Lista de Ingredientes</title>
</head>
<body>
    <h1>Mis Ingredientes</h1>
    
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Calorías</th>
                <th>Proteínas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ingredients as $ingredient)
                <tr>
                    <td>{{ $ingredient->name }}</td>
                    <td>{{ $ingredient->calories }}</td>
                    <td>{{ $ingredient->protein }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
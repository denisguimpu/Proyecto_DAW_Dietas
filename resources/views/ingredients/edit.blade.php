<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Ingrediente - NutriTrack TFG</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2ecc71;
            --primary-dark: #27ae60;
            --primary-light: #d5f5e3;
            --secondary-color: #6c7a89;
            --bg-light: #f8fafc;
            --text-dark: #2c3e50;
            --text-muted: #7f8c8d;
            --border-color: #e2e8f0;
            --white: #ffffff;
        }
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
        }
        
        .navbar-nutri {
            background-color: var(--white);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
            padding: 0.75rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }
        
        .content-card {
            background: var(--white);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }
        
        .content-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: var(--white);
        }
        
        .content-card-body {
            padding: 1.5rem;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.15);
        }
        
        .btn-save {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .btn-save:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.35);
        }
        
        .btn-cancel {
            background: var(--bg-light);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: var(--text-dark);
            transition: all 0.2s ease;
        }
        
        .btn-cancel:hover {
            background: var(--border-color);
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-nutri sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('ingredients.index') }}">
                <i class="bi bi-heart-pulse-fill me-2"></i>NutriTrack
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="mb-4">
            <h1 class="h3 fw-bold mb-1">Editar Ingrediente</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 0.875rem;">
                    <li class="breadcrumb-item"><a href="{{ route('ingredients.index') }}" class="text-decoration-none" style="color: var(--primary-color);">Ingredientes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar</li>
                </ol>
            </nav>
        </div>

        <!-- Edit Form Card -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 col-xl-6">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-pencil-square text-success me-2"></i>{{ $ingredient->name }}
                        </h5>
                    </div>
                    <div class="content-card-body">
                        <form action="{{ route('ingredients.update', $ingredient->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre del Ingrediente</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $ingredient->name }}" required>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label for="calories" class="form-label">Calorías</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="calories" name="calories" value="{{ $ingredient->calories }}" required style="border-radius: 10px 0 0 10px;">
                                        <span class="input-group-text" style="border-radius: 0 10px 10px 0;">kcal</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="protein" class="form-label">Proteínas</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" class="form-control" id="protein" name="protein" value="{{ $ingredient->protein }}" required style="border-radius: 10px 0 0 10px;">
                                        <span class="input-group-text" style="border-radius: 0 10px 10px 0;">g</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label for="fats" class="form-label">Grasas</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" class="form-control" id="fats" name="fats" value="{{ $ingredient->fats }}" required style="border-radius: 10px 0 0 10px;">
                                        <span class="input-group-text" style="border-radius: 0 10px 10px 0;">g</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="carbs" class="form-label">Carbohidratos</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" class="form-control" id="carbs" name="carbs" value="{{ $ingredient->carbs }}" required style="border-radius: 10px 0 0 10px;">
                                        <span class="input-group-text" style="border-radius: 0 10px 10px 0;">g</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="image" class="form-label">Imagen (opcional)</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                @if($ingredient->image)
                                    <small class="text-muted">Imagen actual: {{ $ingredient->image }}</small>
                                @endif
                            </div>
                            
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn btn-success btn-save">
                                    <i class="bi bi-check-lg me-2"></i>Guardar Cambios
                                </button>
                                <a href="{{ route('ingredients.index') }}" class="btn btn-cancel">
                                    <i class="bi bi-x-lg me-2"></i>Cancelar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

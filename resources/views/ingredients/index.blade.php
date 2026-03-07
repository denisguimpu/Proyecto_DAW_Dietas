<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ingredientes - NutriTrack TFG</title>
    
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
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #3498db;
        }
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
        }
        
        /* Navbar Styles */
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
        
        .navbar-brand i {
            margin-right: 0.5rem;
        }
        
        .nav-search {
            max-width: 300px;
        }
        
        .nav-search .form-control {
            border-radius: 25px;
            padding-left: 2.5rem;
            border: 1px solid var(--border-color);
            background-color: var(--bg-light);
        }
        
        .nav-search .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.15);
        }
        
        .nav-search .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            border: 1px solid var(--border-color);
            background: var(--white);
            transition: all 0.2s ease;
        }
        
        .user-dropdown .dropdown-toggle:hover {
            border-color: var(--primary-color);
            background: var(--primary-light);
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        /* Stats Cards */
        .stats-card {
            background: var(--white);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
        }
        
        .stats-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .stats-icon.primary {
            background: var(--primary-light);
            color: var(--primary-color);
        }
        
        .stats-icon.warning {
            background: #fef3cd;
            color: var(--warning);
        }
        
        .stats-icon.info {
            background: #d1ecf1;
            color: var(--info);
        }
        
        .stats-icon.secondary {
            background: #e9ecef;
            color: var(--secondary-color);
        }
        
        .stats-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }
        
        .stats-label {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        
        /* Main Content Card */
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
            padding: 0;
        }
        
        /* Search & Filter Bar */
        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
        }
        
        .search-input-wrapper {
            position: relative;
            flex: 1;
            min-width: 250px;
        }
        
        .search-input-wrapper .form-control {
            padding-left: 2.75rem;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            height: 44px;
        }
        
        .search-input-wrapper .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.15);
        }
        
        .search-input-wrapper .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        .btn-add-new {
            background: var(--primary-color);
            border: none;
            border-radius: 10px;
            padding: 0.65rem 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .btn-add-new:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 204, 113, 0.35);
        }
        
        /* Table Styles */
        .table-nutri {
            margin-bottom: 0;
        }
        
        .table-nutri thead th {
            background: var(--bg-light);
            border-bottom: 2px solid var(--border-color);
            padding: 1rem 1.25rem;
            font-weight: 600;
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            white-space: nowrap;
        }
        
        .table-nutri tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }
        
        .table-nutri tbody tr:hover {
            background: rgba(46, 204, 113, 0.04);
        }
        
        .table-nutri tbody tr:last-child td {
            border-bottom: none;
        }
        
        .ingredient-img {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            background: var(--bg-light);
            border: 1px solid var(--border-color);
        }
        
        .ingredient-name {
            font-weight: 600;
            color: var(--text-dark);
        }
        
        .badge-calories {
            background: #fef3cd;
            color: #856404;
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8125rem;
        }
        
        .nutrient-value {
            font-weight: 500;
            color: var(--text-dark);
        }
        
        .nutrient-unit {
            color: var(--text-muted);
            font-size: 0.8125rem;
        }
        
        /* Action Buttons */
        .btn-action {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.2s ease;
        }
        
        .btn-edit {
            background: #fef3cd;
            color: #856404;
        }
        
        .btn-edit:hover {
            background: var(--warning);
            color: white;
        }
        
        .btn-delete {
            background: #f8d7da;
            color: #721c24;
        }
        
        .btn-delete:hover {
            background: var(--danger);
            color: white;
        }
        
        /* Empty State */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }
        
        .empty-state-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: var(--primary-color);
        }
        
        .empty-state h4 {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }
        
        /* Pagination */
        .pagination-wrapper {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border-color);
            background: var(--bg-light);
        }
        
        .page-link {
            border: none;
            color: var(--text-muted);
            padding: 0.5rem 0.85rem;
            border-radius: 8px;
            margin: 0 2px;
            font-weight: 500;
        }
        
        .page-link:hover {
            background: var(--primary-light);
            color: var(--primary-color);
        }
        
        .page-item.active .page-link {
            background: var(--primary-color);
            color: white;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .stats-card {
                padding: 1.25rem;
            }
            
            .stats-value {
                font-size: 1.5rem;
            }
            
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input-wrapper {
                width: 100%;
            }
            
            .btn-add-new {
                width: 100%;
                justify-content: center;
            }
            
            .content-card-header {
                padding: 1rem;
            }
        }
        
        /* Dropdown Styles */
        .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
        }
        
        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: var(--primary-light);
            color: var(--primary-color);
        }
        
        .dropdown-item i {
            margin-right: 0.5rem;
            width: 18px;
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-nutri sticky-top">
        <div class="container-fluid px-4">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <i class="bi bi-heart-pulse-fill"></i>NutriTrack
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="bi bi-list fs-4"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Center Search (Desktop) -->
                <div class="mx-auto d-none d-lg-block">
                    <div class="nav-search position-relative">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control" placeholder="Buscar en NutriTrack...">
                    </div>
                </div>
                
                <!-- Right Side -->
                <div class="d-flex align-items-center gap-3 ms-auto">
                    <!-- Notifications -->
                    <button class="btn btn-link text-muted position-relative p-2">
                        <i class="bi bi-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                            3
                        </span>
                    </button>
                    
                    <!-- User Dropdown -->
                    <div class="dropdown user-dropdown">
                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="d-none d-md-block text-start">
                                <div class="fw-semibold text-dark" style="font-size: 0.875rem;">{{ Auth::user()->name ?? 'Usuario' }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">Administrador</div>
                            </div>
                            <i class="bi bi-chevron-down text-muted ms-1"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end mt-2">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid px-4 py-4">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Ingredientes</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-size: 0.875rem;">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none" style="color: var(--primary-color);">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ingredientes</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Stats Cards Row -->
        <div class="row g-4 mb-4">
            <!-- Total Ingredients -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon primary">
                            <i class="bi bi-database"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stats-value">{{ $ingredients->count() ?? 0 }}</div>
                            <div class="stats-label">Total Ingredientes</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Avg Calories -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon warning">
                            <i class="bi bi-fire"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stats-value">{{ number_format($ingredients->avg('calories') ?? 0, 0) }}</div>
                            <div class="stats-label">Calorías Promedio</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Top Protein Source -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon info">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stats-value" style="font-size: 1.25rem;">
                                {{ $ingredients->sortByDesc('protein')->first()?->name ?? 'N/A' }}
                            </div>
                            <div class="stats-label">Mayor Proteína</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Last Updated -->
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stats-card">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon secondary">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="ms-3">
                            <div class="stats-value" style="font-size: 1rem;">
                                {{ $ingredients->count() > 0 && $ingredients->sortByDesc('updated_at')->first()?->updated_at ? $ingredients->sortByDesc('updated_at')->first()->updated_at->diffForHumans() : 'N/A' }}
                            </div>
                            <div class="stats-label">Última Actualización</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="content-card">
            <!-- Card Header with Search & Filter -->
            <div class="content-card-header">
                <div class="filter-bar">
                    <div class="search-input-wrapper">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control" id="searchIngredient" placeholder="Buscar ingrediente...">
                    </div>
                    
                    <div class="d-flex gap-2">
                        <select class="form-select" style="border-radius: 10px; height: 44px; min-width: 150px;">
                            <option selected>Todos</option>
                            <option value="high-protein">Alta Proteína</option>
                            <option value="low-cal">Bajo en Calorías</option>
                            <option value="low-fat">Bajo en Grasas</option>
                        </select>
                        
                        <button class="btn btn-add-new btn-success" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
                            <i class="bi bi-plus-lg"></i>
                            <span class="d-none d-sm-inline">Nuevo Ingrediente</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Card Body - Table -->
            <div class="content-card-body">
                @if($ingredients->count() > 0)
                <div class="table-responsive">
                    <table class="table table-nutri">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Calorías</th>
                                <th>Proteínas</th>
                                <th>Grasas</th>
                                <th>Carbohidratos</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ingredients as $ingredient)
                            <tr>
                                <td>
                                    <span class="text-muted">#{{ $ingredient->id }}</span>
                                </td>
                                <td>
                                    @if($ingredient->image)
                                        <img src="{{ asset('storage/' . $ingredient->image) }}" alt="{{ $ingredient->name }}" class="ingredient-img">
                                    @else
                                        <div class="ingredient-img d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="ingredient-name">{{ $ingredient->name }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-calories">
                                        {{ $ingredient->calories }} kcal
                                    </span>
                                </td>
                                <td>
                                    <span class="nutrient-value">{{ $ingredient->protein }}</span>
                                    <span class="nutrient-unit">g</span>
                                </td>
                                <td>
                                    <span class="nutrient-value">{{ $ingredient->fats }}</span>
                                    <span class="nutrient-unit">g</span>
                                </td>
                                <td>
                                    <span class="nutrient-value">{{ $ingredient->carbs ?? 0 }}</span>
                                    <span class="nutrient-unit">g</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button class="btn btn-action btn-edit" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                title="Editar ingrediente"
                                                onclick="window.location.href='{{ route('ingredients.edit', $ingredient->id) }}'">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este ingrediente?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-action btn-delete" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="top" 
                                                    title="Eliminar ingrediente">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($ingredients instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="pagination-wrapper d-flex justify-content-between align-items-center">
                    <div class="text-muted" style="font-size: 0.875rem;">
                        Mostrando {{ $ingredients->firstItem() }} - {{ $ingredients->lastItem() }} de {{ $ingredients->total() }} ingredientes
                    </div>
                    <nav>
                        {{ $ingredients->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
                @endif
                
                @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h4>No se encontraron ingredientes</h4>
                    <p>Comienza agregando tu primer ingrediente a la base de datos.</p>
                    <button class="btn btn-success btn-add-new" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
                        <i class="bi bi-plus-lg"></i>
                        Agregar Primer Ingrediente
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Ingredient Modal -->
    <div class="modal fade" id="addIngredientModal" tabindex="-1" aria-labelledby="addIngredientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="addIngredientModalLabel">
                        <i class="bi bi-plus-circle text-success me-2"></i>Nuevo Ingrediente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-3">
                    <form action="{{ route('ingredients.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nombre del Ingrediente</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ej: Pechuga de Pollo" required style="border-radius: 10px; padding: 0.75rem 1rem;">
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="calories" class="form-label fw-semibold">Calorías</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="calories" name="calories" placeholder="0" required style="border-radius: 10px 0 0 10px;">
                                    <span class="input-group-text" style="border-radius: 0 10px 10px 0;">kcal</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="protein" class="form-label fw-semibold">Proteínas</label>
                                <div class="input-group">
                                    <input type="number" step="0.1" class="form-control" id="protein" name="protein" placeholder="0" required style="border-radius: 10px 0 0 10px;">
                                    <span class="input-group-text" style="border-radius: 0 10px 10px 0;">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label for="fats" class="form-label fw-semibold">Grasas</label>
                                <div class="input-group">
                                    <input type="number" step="0.1" class="form-control" id="fats" name="fats" placeholder="0" required style="border-radius: 10px 0 0 10px;">
                                    <span class="input-group-text" style="border-radius: 0 10px 10px 0;">g</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="carbs" class="form-label fw-semibold">Carbohidratos</label>
                                <div class="input-group">
                                    <input type="number" step="0.1" class="form-control" id="carbs" name="carbs" placeholder="0" required style="border-radius: 10px 0 0 10px;">
                                    <span class="input-group-text" style="border-radius: 0 10px 10px 0;">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Imagen (opcional)</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" style="border-radius: 10px; padding: 0.75rem 1rem;">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg" style="border-radius: 10px;">
                                <i class="bi bi-check-lg me-2"></i>Guardar Ingrediente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Initialize Tooltips & Search -->
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Simple client-side search
            const searchInput = document.getElementById('searchIngredient');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    const tableRows = document.querySelectorAll('.table-nutri tbody tr');
                    
                    tableRows.forEach(row => {
                        const name = row.querySelector('.ingredient-name');
                        if (name) {
                            const text = name.textContent.toLowerCase();
                            row.style.display = text.includes(searchTerm) ? '' : 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>

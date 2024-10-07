<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Gestión de Tareas</title>
    <style>
        .edit-form {
            display: none; /* Esconde el formulario por defecto */
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid justify-content-center">
            <a class="navbar-brand" href="#" style="font-size: 2rem;">To-Do List</a>
        </div>
    </nav>
    
    <div class="container py-5">
        <h1 class="mb-4">Lista de Tareas</h1>

        <!-- Mostrar mensajes de éxito -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario para crear nueva tarea -->
        <form action="{{ route('tasks.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="title" placeholder="Nueva Tarea" class="form-control @error('title') is-invalid @enderror" required>
                <button type="submit" class="btn btn-primary">Añadir</button>
            </div>
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </form>

        <!-- Lista de tareas -->
        <ul class="list-group">
            @foreach($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        {{ $task->title }}
                    </div>
                    <div class="d-flex">
                        <!-- Botón de edición -->
                        <button type="button" class="btn btn-warning btn-sm me-2 edit-button" data-task-id="{{ $task->id }}">Editar</button>
                        <!-- Botón de eliminación -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $task->id }}">
                            Eliminar
                        </button>

                        <!-- Modal de confirmación -->
                        <div class="modal fade" id="confirmDeleteModal-{{ $task->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar la tarea "{{ $task->title }}"?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de edición -->
                    <div class="edit-form" id="edit-form-{{ $task->id }}">
                        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" name="title" value="{{ $task->title }}" class="form-control mt-2 @error('title') is-invalid @enderror" required>
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Guardar</button>
                            <button type="button" class="btn btn-secondary btn-sm mt-2 cancel-edit" data-task-id="{{ $task->id }}">Cancelar</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        // Mostrar el formulario de edición
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                document.getElementById(`edit-form-${taskId}`).style.display = 'block';
            });
        });

        // Ocultar el formulario de edición
        document.querySelectorAll('.cancel-edit').forEach(button => {
            button.addEventListener('click', function() {
                const taskId = this.getAttribute('data-task-id');
                document.getElementById(`edit-form-${taskId}`).style.display = 'none';
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

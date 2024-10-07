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
        <div class="container-fluid">
            <a class="navbar-brand" href="#">To-Do List</a>
        </div>
    </nav>
    
    <div class="container py-5">
        <h1 class="mb-4">Lista de Tareas</h1>

        <!-- Formulario para crear nueva tarea -->
        <form action="{{ route('tasks.store') }}" method="POST" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="title" placeholder="Nueva Tarea" class="form-control" required>
                <button type="submit" class="btn btn-primary">Añadir</button>
            </div>
        </form>

        <!-- Lista de tareas -->
        <ul class="list-group">
            @foreach($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="me-3">
                            @csrf
                            @method('PUT')
                            <input type="checkbox" name="is_completed" {{ $task->is_completed ? 'checked' : '' }} onclick="this.form.submit()">
                        </form>
                        {{ $task->title }}
                    </div>
                    <div class="d-flex">
                        <!-- Botón de edición -->
                        <button type="button" class="btn btn-warning btn-sm me-2 edit-button" data-task-id="{{ $task->id }}">Editar</button>
                        <!-- Formulario de eliminación -->
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </div>

                    <!-- Formulario de edición -->
                    <div class="edit-form" id="edit-form-{{ $task->id }}">
                        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" name="title" value="{{ $task->title }}" class="form-control mt-2" required>
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
</body>
</html>

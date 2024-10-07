<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Tareas</title>
</head>
<body>
    <h1>Lista de Tareas</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Nueva Tarea" required>
        <button type="submit">Añadir</button>
    </form>

    <ul>
        @foreach($tasks as $task)
            <li>
                {{ $task->title }}
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="checkbox" name="is_completed" {{ $task->is_completed ? 'checked' : '' }} onclick="this.form.submit()">
                </form>

                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>

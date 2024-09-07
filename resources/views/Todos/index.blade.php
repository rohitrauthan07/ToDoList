<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>To Do List App</h2>
        <input type="text" id="taskInput" class="form-control" placeholder="Add Task">
        <button class="btn btn-primary mt-2" id="addTaskBtn">Add Task</button>
        <button class="btn btn-secondary mt-2" id="showAllTasksBtn">Show All Tasks</button>
        <h4 class="mt-4">Tasks</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="taskList">
                @foreach ($todos as $todo)
                    <tr data-id="{{ $todo->id }}">
                        <td>{{ $todo->name }}</td>
                        <td>
                            <span class="task-status">
                                {{ $todo->status ? 'Complete' : 'Incomplete' }}
                            </span>
                        </td>
                        <td>
                            <input type="checkbox" class="toggle-status" data-id="{{ $todo->id }}" {{ $todo->status ? 'checked' : '' }} style="display: {{ $todo->status ? 'none' : 'inline-block' }};">
                            <button class="btn btn-danger btn-sm delete-task" data-id="{{ $todo->id }}">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#addTaskBtn').click(function () {
                let taskName = $('#taskInput').val();
                if (taskName.trim() === '') {
                    alert('Please enter a task name.');
                    return;
                }
                $.ajax({
                    url: '/todos',
                    method: 'POST',
                    data: {
                        name: taskName
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#taskList').append(`
                                <tr data-id="${response.task.id}">
                                    <td>${response.task.name}</td>
                                    <td><span class="task-status">Incomplete</span></td>
                                    <td>
                                        <input type="checkbox" class="toggle-status" data-id="${response.task.id}">
                                        <button class="btn btn-danger btn-sm delete-task" data-id="${response.task.id}">Delete</button>
                                    </td>
                                </tr>
                            `);
                            $('#taskInput').val('');
                        } else {
                            alert('Duplicate Task');
                        }
                    },
                    error: function (xhr) {
                        alert('Duplicate Task');
                    }
                });
            });
            $(document).on('change', '.toggle-status', function () {
                let taskId = $(this).data('id');
                let $taskRow = $(this).closest('tr');
                let isChecked = $(this).is(':checked');
                $.ajax({
                    url: `/todos/${taskId}/status`,
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            if (isChecked) {
                                $taskRow.find('.toggle-status').hide();
                                $taskRow.hide();
                                $taskRow.find('.task-status').text('Complete');
                            } else {
                                $taskRow.find('.toggle-status').show();
                                $taskRow.show();
                                $taskRow.find('.task-status').text('Incomplete');
                            }
                        } else {
                            alert('Failed to update task status.');
                        }
                    },
                    error: function (xhr) {
                        alert('Failed to update task status. Please try again.');
                    }
                });
            });
            $(document).on('click', '.delete-task', function () {
                let taskId = $(this).data('id');
                let $taskRow = $(this).closest('tr');
                if (confirm('Are you sure you want to delete this task?')) {
                    $.ajax({
                        url: `/todos/${taskId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                $taskRow.remove();
                            } else {
                                alert('Failed to delete task. Please try again.');
                            }
                        },
                        error: function (xhr) {
                            alert('Failed to delete task. Please try again.');
                        }
                    });
                }
            });
            $('#showAllTasksBtn').click(function () {
                $.ajax({
                    url: '/todos?show_all=1',
                    method: 'GET',
                    success: function (response) {
                        $('#taskList').empty();
                        response.todos.forEach(function (todo) {
                            $('#taskList').append(`
                    <tr data-id="${todo.id}">
                        <td>${todo.name}</td>
                        <td>
                            <span class="task-status">${todo.status ? 'Complete' : 'Incomplete'}</span>
                        </td>
                        <td>
                            <input type="checkbox" class="toggle-status" data-id="${todo.id}" ${todo.status ? 'checked' : ''} style="display: ${todo.status ? 'none' : 'inline-block'};">
                            <button class="btn btn-danger btn-sm delete-task" data-id="${todo.id}">Delete</button>
                        </td>
                    </tr>
                `);
                        });
                    },
                    error: function (xhr) {
                        alert('Failed to load tasks. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
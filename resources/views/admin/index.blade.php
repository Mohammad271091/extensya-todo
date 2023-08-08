@extends('layouts.app')
@section('content')
    <div class="container">

        {{-- success messages  --}}
        <div class="alert alert-success" id="newTaskSuccessAlert" style="display: none;">
            Task created successfully
        </div>

        {{-- Task deletion alert  --}}
        <div class="alert alert-success" id="deleteSuccessAlert" style="display: none;">
            Task deleted successfully!
        </div>

        {{-- Task update alert  --}}
        <div class="alert alert-success" id="updateSuccessAlert" style="display: none;">
            Task updated successfully!
        </div>


        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tasks">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#users">Users</a>
                    </li>
                </ul>
                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- Tasks Tab Content -->
                    <div id="tasks" class="tab-pane fade show active">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newTask">+ New
                            Task</button>
                        <div class="card mt-3">
                            <div class="card-header">{{ __('Todo List') }}</div>
                            @php
                                $x = 0;
                            @endphp
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Task</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Time added</th>
                                            <th scope="col">Operations</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tasks as $task)
                                            <tr id="task_{{ $task->id }}">
                                                <th scope="row">{{ ++$x }}</th>
                                                <td class="task">{{ $task->task }}</td>
                                                <td class="description">{{ $task->description }}</td>
                                                <td>{{ $task->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <i class="fa fa-trash btn-delete fa-2x"
                                                        style="color: tomato; cursor: pointer;"
                                                        data-id="{{ $task->id }}"></i>

                                                    <i class="fa fa-pencil-square btn-edit fa-2x" aria-hidden="true"
                                                        style="color: teal;cursor: pointer;" data-id="{{ $task->id }}"
                                                        data-task="{{ $task->task }}"
                                                        data-description="{{ $task->description }}"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Users Tab Content -->
                    <div id="users" class="tab-pane fade">
                        <div class="card mt-3">
                            <div class="card-header">{{ __('Users List') }}</div>
                            @php
                                $y = 0;
                            @endphp
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Real-time Notification</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <th scope="row">{{ ++$y }}</th>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <button class="btn btn-outline-danger notify w-100"
                                                        data-user-id="{{ $user->id }}"
                                                        data-user-name="{{ $user->name }}">Notify</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding a new task -->
    <div class="modal fade" id="newTask" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Task form -->
                    <form id="taskForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="task">Task</label>
                            <input type="text" class="form-control @error('task') is-invalid @enderror" id="task"
                                name="task">
                            @error('task')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class='form-control @error('description') is-invalid @enderror' id="description" name="description"
                                rows="3"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveTask">Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this task?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Yes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for updating tasks  --}}
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Task edit form -->
                    <form id="editTaskForm" method="POST">
                        @csrf
                        <input type="hidden" id="editTaskId" name="id">
                        <div class="form-group">
                            <label for="editTask">Task</label>
                            <input type="text" class="form-control" id="editTask" name="task">
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEditTask">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal to send private notifications to users  --}}
    <div class="modal fade" id="notifyModal" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notifyModalLabel">Notify User #<span id="userIdTitle"></span>(<span
                            id="userNameTitle"></span>)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="notifyForm">
                        <textarea class="form-control" name="message" placeholder="Enter the real-time notification content"></textarea>
                        <input type="hidden" name="userId" id="userId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendNotification">Send</button>
                </div>
            </div>
        </div>
    </div>





    {{-- script and style for toastr --}}
    {{-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <script>
        $(document).ready(function() {
            // New task 
            $('#saveTask').click(function() {
                const formData = $('#taskForm').serialize();

                $.ajax({
                    url: '/admin/store', // Replace with your Laravel route for storing tasks
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Close the modal
                        $('#newTask').modal('hide');

                        // Clear the form inputs
                        $('#taskForm')[0].reset();

                        // Show the success alert
                        showSuccessAlert();

                        // Append the new task to the table
                        const newRow = '<tr>' +
                            '<th scope="row">N/A</th>' +
                            '<td>' + response.task + '</td>' +
                            '<td>' + response.description + '</td>' +
                            '<td>Just now</td>' +
                            '<td>' +
                            '<i class="fa fa-trash btn-delete fa-2x" style="color: tomato; cursor: pointer;" data-id="' +
                            response.id + '"></i>' +
                            '<i class="fa fa-pencil-square fa-2x" style="color: teal;cursor: pointer;" aria-hiddent="true"></i>'
                        '</td>' +
                        '</tr>';
                        $('table tbody').append(newRow);

                        // Update the IDs of the existing rows
                        $('table tbody tr').each(function(index) {
                            $(this).find('th').text(index + 1);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            function showSuccessAlert() {
                $('#newTaskSuccessAlert').fadeIn().delay(2000).fadeOut();
            }



            // Delete task 
            $('.btn-delete').click(function() {

                const deleteBtn = $(this);
                const taskId = deleteBtn.data('id');
                $('#deleteConfirmationModal').modal('show');

                // Handle click event of the "Yes" button in the confirmation modal
                $('#confirmDeleteBtn').click(function() {
                    // Perform the AJAX request to delete the task
                    $.ajax({
                        url: '/admin/delete/' + taskId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Close the confirmation modal
                            $('#deleteConfirmationModal').modal('hide');

                            // Remove the task row from the table
                            $('#task_' + taskId).remove();

                            // show the success alert 
                            showDeleteSuccessAlert();
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            });


            function showDeleteSuccessAlert() {
                $('#deleteSuccessAlert').fadeIn().delay(2000).fadeOut();
            }


            // open the edit task modal 
            $('.btn-edit').click(function() {
                const taskId = $(this).data('id');
                const taskText = $(this).data('task');
                const descriptionText = $(this).data('description');

                // Set the data in the edit modal inputs
                $('#editTaskId').val(taskId);
                $('#editTask').val(taskText);
                $('#editDescription').val(descriptionText);

                // Open the edit modal
                $('#editTaskModal').modal('show');
            });


            // send the updated task data to server 
            $('#saveEditTask').click(function() {
                const taskId = $('#editTaskId').val();
                const taskText = $('#editTask').val();
                const descriptionText = $('#editDescription').val();

                $.ajax({
                    url: '/admin/update/' + taskId,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        task: taskText,
                        description: descriptionText
                    },
                    success: function(response) {
                        // Close the edit modal
                        $('#editTaskModal').modal('hide');

                        // Show the update success alert
                        showUpdateSuccessAlert();

                        // update the table without refresh
                        const taskRow = $('#task_' + taskId);
                        taskRow.find('.task').text(taskText);
                        taskRow.find('.description').text(descriptionText);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        if (xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            // Display validation errors under each input
                            Object.keys(errors).forEach((field) => {
                                const input = $('#' + field);
                                input.addClass('is-invalid');
                                input.next('.invalid-feedback').text(errors[field][0]);
                            });
                        }
                    }
                });
            });

            function showUpdateSuccessAlert() {
                $('#updateSuccessAlert').fadeIn().delay(2000).fadeOut();
            }


            // Handle Notify button click
            $('.notify').on('click', function() {
                var userId = $(this).data('user-id');
                var userName = $(this).data('user-name');
                $('#userId').val(userId);
                $('#userIdTitle').html(userId);
                $('#userNameTitle').html(userName);
                $('#notifyModal').modal('show');
            });

            // send the wanted user and message to admin controller in order to send the real-time notification
            $('#sendNotification').on('click', function() {
                var message = $('#notifyForm textarea[name="message"]').val();
                var userId = $('#userId').val();

                $.ajax({
                    url: '/admin/private-notification',
                    method: 'POST',
                    data: {
                        message: message,
                        userId: userId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        console.log('Notification sent successfully:', response);
                        $('#notifyModal').modal('hide');
                    },
                    error: function(error) {
                        console.error('Error sending notification:', error);
                    }
                });

                $('#notifyModal').modal('hide');
            });



            // Echo 
            var newTaskChannel = Echo.channel('new-task');
            newTaskChannel.listen('.new-task', function(data) {
                toastr.info(data.message, 'New task was added by the admin');
            });

            var deleteTaskChannel = Echo.channel('delete-task');
            deleteTaskChannel.listen('.delete-task', function(data) {
                toastr.error(data.message, 'A task was deleted by the admin');
            });

            var updateTaskChannel = Echo.channel('update-task');
            updateTaskChannel.listen('.update-task', function(data) {
                toastr.warning(data.message, 'A task was updated by the admin');
            });

            var userId = '{{ Auth::id() }}';
            var privateNotification = Echo.private(`private-notif.${userId}`);
            privateNotification.listen('.private-notif', function(data) {
                toastr.success(data.message, 'A private message from the admin');
            });


            // Pusher JS
            // var pusher = new Pusher("a42f3e988eab04859bb8", {
            // cluster: 'ap2',
            // });

            // Pusher.logToConsole = true;

            // var newTaskChannel = pusher.subscribe('new-task');
            // var deleteTaskChannel = pusher.subscribe('delete-task');
            // var updateTaskChannel = pusher.subscribe('private-update-task');

            // newTaskChannel.bind('App\\Events\\NewTaskEvent', (data) => {
            // // Show the notification to everyone
            // toastr.info(data.message, 'New task was added by the admin');
            // });

            // deleteTaskChannel.bind('App\\Events\\DeleteTaskEvent', (data) => {
            // // Show the notification to everyone
            // toastr.error(data.message, 'A task was deleted by the admin');
            // });

            // updateTaskChannel.bind('App\\Events\\UpdateTaskEvent', (data) => {
            // // Show the notification to everyone
            // toastr.warning(data.message, 'A task was updated by the admin');
            // });
        });
    </script>
@endsection

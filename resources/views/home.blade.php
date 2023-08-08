@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <th scope="row">{{ ++$x }}</th>
                                        <td>{{ $task->task }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->created_at->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- scripts for toastr and pusher  --}}
    {{-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script>
        $(document).ready(function() {
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
        });
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        // var pusher = new Pusher('a42f3e988eab04859bb8', {
        //     cluster: 'ap2',
        //     channelAuthorization: {
        //             endpoint: "/pusher_auth.php"
        //         },
        // });

        // // subscribing to add, update, and delete events
        // var newTaskChannel = pusher.subscribe('new-task');
        // var deleteTaskChannel = pusher.subscribe('delete-task');
        // var updateTaskChannel = pusher.subscribe('private-update-task');


        // newTaskChannel.bind('App\\Events\\NewTaskEvent', (data) => {
        //     toastr.info(data.message, 'New task was added by the admin');
        // });

        // deleteTaskChannel.bind('App\\Events\\DeleteTaskEvent', (data) => {
        //     toastr.error(data.message, 'A task was deleted by the admin');
        // });

        // updateTaskChannel.bind('App\\Events\\UpdateTaskEvent', (data) => {
        //         // Show the notification to everyone 
        //         toastr.warning(data.message, 'A task was updated by the admin');
        //     });
    </script>
@endsection

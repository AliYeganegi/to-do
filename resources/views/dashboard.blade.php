@extends('layouts.master')

@section('content')
    @if (auth()->check())
        <section class="vh-100 gradient-custom-2">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-12 col-xl-10">
                        <div class="card">
                            <div class="card-body p-4 text-dark">
                                <div class="text-center pt-3 pb-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-todo-list/check1.webp"
                                        alt="Check" width="60">
                                    <h2 class="my-4">Task List</h2>
                                </div>

                                <!-- New Task Button -->
                                <div class="text-end mb-3">
                                    <button type="button" class="btn btn-primary" id="newTaskButton">New Task</button>
                                </div>

                                <table class="table text-dark mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Task</th>
                                            <th scope="col">Details</th>
                                            <th scope="col">Priority</th>
                                            <th scope="col">Deadline</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tasks as $task)
                                            <tr class="fw-normal">
                                                {{-- <th>
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                                        alt="avatar 1" style="width: 45px; height: auto;">
                                                    <span class="ms-2">{{ $task->title }}</span>
                                                </th> --}}
                                                <td class="align-middle">{{ $task->title }}</td>
                                                <td class="align-middle">{{ $task->description }}</td>
                                                <td class="align-middle">
                                                    <h6 class="mb-0"><span
                                                            class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'low' ? 'success' : 'warning') }}">{{ ucfirst($task->priority) }}
                                                            priority</span></h6>
                                                </td>
                                                <td class="align-middle">{{ $task->deadline }}</td>
                                                <td class="align-middle">{{ ucfirst($task->status) }}</td>
                                                <td class="align-middle">
                                                    <form action="{{ route('changeStatus', $task) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @if ($task->status == 'in_progress')
                                                            <button type="submit" class="btn btn-success"
                                                                data-mdb-tooltip-init title="Mark as Finished">
                                                                <i class="bi bi-check">☐</i>
                                                            </button>
                                                        @else
                                                            <button type="submit" class="btn btn-success"
                                                                data-mdb-tooltip-init title="Mark as in_progress">
                                                                <i class="bi bi-check">✓</i>
                                                            </button>
                                                        @endif
                                                    </form>


                                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" data-mdb-tooltip-init
                                                            title="Remove Task">
                                                            <i class="bi bi-trash"></i> ✘
                                                        </button>
                                                    </form>
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
        </section>

        <!-- New Task Modal -->
        <div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="exampleModalLabel">New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form to add new task -->
                        <form action="{{ route('tasks.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="taskTitle" class="form-label">Title</label>
                                <input name="title" class="form-control" id="taskTitle">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="taskDescription" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="taskDescription" rows="3"></textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="taskPriority" class="form-label">Priority</label>
                                    <select name="priority" class="form-select" id="taskPriority">
                                        <option value="low">Low</option>
                                        <option value="normal" selected>Normal</option>
                                        <option value="high">High</option>
                                    </select>
                                    @error('priority')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="taskColor" class="form-label">Color</label>
                                    <select name="color" class="form-select" id="taskColor">
                                        <option value="white">White</option>
                                        <option value="black">Black</option>
                                        <option value="red">Red</option>
                                        <option value="yellow">Yellow</option>
                                        <option value="green">Green</option>
                                        <option value="blue">Blue</option>
                                    </select>
                                    @error('color')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="taskDeadline" class="form-label">Deadline</label>
                                    <input name="deadline" type="datetime-local" class="form-control" id="taskDeadline">
                                    @error('deadline')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Task</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script>
            // JavaScript to show modal when New Task button is clicked
            const newTaskButton = document.getElementById('newTaskButton');
            newTaskButton.addEventListener('click', () => {
                const newTaskModal = new bootstrap.Modal(document.getElementById('newTaskModal'));
                newTaskModal.show();
            });
        </script>
    @else
        <script>
            window.location = "{{ route('login') }}";
        </script>
    @endif
@endsection

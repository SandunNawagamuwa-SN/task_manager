@extends('layouts.app')

@section('content')
    <div class="md:container md:mx-auto py-10">
        <div class="flex justify-center">
            <h1 class="text-4xl font-semibold font-mono">Task List</h1>
        </div>
        <div class="py-10 ">
            <form id="task-update-form" method="POST">
                @csrf
                <table id="taskTable" class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-base font-bold">
                        <tr>
                            <th scope="col" class="py-3 px-6 text-left">Title</th>
                            <th scope="col" class="py-3 px-6 text-left">Status</th>
                            <th scope="col" class="py-3 px-6 text-left">Due Date</th>
                            <th scope="col" class="py-3 px-6 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-medium">
                        @foreach ($tasks as $task)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6">{{ $task->title }}</td>
                                <td class="py-3 px-6">
                                    <span
                                        class="{{ $task->status === 'completed' ? 'text-green-500' : ($task->status === 'in-progress' ? 'text-yellow-500' : 'text-red-500') }}">
                                        {{ strtoupper($task->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6">{{ $task->due_date->format('Y-m-d') }}</td>
                                <td class="py-3 px-6">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded complete-task"
                                        data-task-id="{{ $task->id }}">
                                        COMPLETE
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#taskTable').DataTable();
        });
    </script>
    <script>
        console.log('abc')
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.complete-task');

            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('fired')
                    const taskId = this.getAttribute('data-task-id');

                    fetch(`/tasks/${taskId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                status: 'completed'
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                const row = button.closest('tr');
                                const statusCell = row.querySelector('td:nth-child(2) span');
                                statusCell.textContent = 'Completed';
                                statusCell.className =
                                    'text-green-500';

                                button.disabled = true;
                                button.classList.replace('bg-blue-500', 'bg-gray-400');
                                button.classList.replace('hover:bg-blue-700',
                                    'hover:bg-gray-500');
                                button.textContent = 'Completed'
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endsection

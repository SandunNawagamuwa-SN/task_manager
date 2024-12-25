@extends('layouts.app')

@section('content')
    <div class="md:container md:mx-auto py-10">

        <div class="flex justify-center">
            <h1 class="text-4xl font-semibold font-mono">Task List</h1>
        </div>

        <div id="successMessage" class="hidden mt-4 px-4 py-2 bg-green-500 text-white rounded-md shadow-md text-center font-semibold transition-all duration-300 opacity-0">
            Task status updated successfully!
        </div>

        <div id="errorMessage" class="hidden mt-4 px-4 py-2 bg-red-500 text-white rounded-md shadow-md text-center font-semibold transition-all duration-300 opacity-0">
            An error occurred while updating the task. Please try again later.
        </div>

        <div class="py-10">
            <table id="taskTable" class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md overflow-hidden mt-4">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm font-bold">
                    <tr>
                        <th scope="col" class="py-3 px-6 text-left">Title</th>
                        <th scope="col" class="py-3 px-6 text-left">Status</th>
                        <th scope="col" class="py-3 px-6 text-left">Due Date</th>
                        <th scope="col" class="py-3 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-medium">
                    @foreach ($tasks as $task)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 transition duration-200">
                            <td class="py-3 px-6">{{ $task->title }}</td>
                            <td class="py-3 px-6">
                                <span class="{{ $task->status === 'completed' ? 'text-green-500' : ($task->status === 'in-progress' ? 'text-yellow-500' : 'text-red-500') }}">
                                    {{ strtoupper($task->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-6">{{ $task->due_date->format('Y-m-d') }}</td>
                            <td class="py-3 px-6">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded complete-task" data-task-id="{{ $task->id }}">
                                    COMPLETE
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#taskTable').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: "Filter tasks:",
                    lengthMenu: "Show _MENU_ tasks",
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.complete-task');

            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const taskId = this.getAttribute('data-task-id');

                    document.getElementById('successMessage').classList.add('hidden');
                    document.getElementById('errorMessage').classList.add('hidden');

                    fetch(`/tasks/${taskId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ status: 'completed' })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const successMessage = document.getElementById('successMessage');
                            successMessage.textContent = data.message;
                            successMessage.classList.remove('hidden');
                            successMessage.style.opacity = '1';

                            setTimeout(() => {
                                successMessage.style.opacity = '0';
                                setTimeout(() => successMessage.classList.add('hidden'), 500);
                            }, 3000);

                            const row = button.closest('tr');
                            const statusCell = row.querySelector('td:nth-child(2) span');
                            statusCell.textContent = 'COMPLETED';
                            statusCell.className = 'text-green-500';

                            button.disabled = true;
                            button.classList.replace('bg-blue-500', 'bg-gray-400');
                            button.classList.replace('hover:bg-blue-700', 'hover:bg-gray-500');
                            button.textContent = 'COMPLETED';
                        }
                    })
                    .catch(error => {
                        const errorMessage = document.getElementById('errorMessage');
                        errorMessage.textContent = 'An error occurred while updating the task. Please try again later.';
                        errorMessage.classList.remove('hidden');
                        errorMessage.style.opacity = '1';

                        setTimeout(() => {
                            errorMessage.style.opacity = '0';
                            setTimeout(() => errorMessage.classList.add('hidden'), 500);
                        }, 3000);

                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
@endsection

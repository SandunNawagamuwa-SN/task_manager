@extends('layouts.app')

@section('content')
    <div class="md:container md:mx-auto py-10">
        <div class="flex justify-center">
            <h1 class="text-4xl font-semibold font-sans">Task Manager</h1>
        </div>
        <div class="py-10 px-10">
            <form id="taskForm" method="POST">
                @csrf
                <div class="col-span-full">
                    <label for="title" class="block text-lg font-medium text-gray-900">Title<span
                            class="text-red-500">&#65290;</span></label>
                    <div class="mt-2">
                        <input type="text" name="title" id="title"
                            class="block w-full rounded-sm bg-white px-3 py-2 text-xl text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-lg placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-black-600 sm:text-sm/6"
                            placeholder="Task Here">
                    </div>
                </div>

                <div class="col-span-full mt-6">
                    <label for="description" class="block text-lg font-medium text-gray-900">Description<span
                            class="text-red-500">&#65290;</span></label>
                    <div class="mt-2">
                        <textarea name="description" id="description" rows="8"
                            class="block w-full rounded-sm bg-white px-3 py-2 text-xl text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-lg placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-black-900 sm:text-sm/6"
                            placeholder="Explain your Task Here"></textarea>
                    </div>
                </div>
                <div class="relative col-span-full mt-6">
                    <label for="datepicker" class="block text-lg font-medium text-gray-900">Due Date<span
                            class="text-red-500">&#65290;</span></label>
                    <div class="mt-2 relative">
                        <input id="datepicker" type="text" name="due_date"
                            class="block w-full rounded-sm bg-white px-3 py-3 text-xl text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-lg placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-black-900 sm:text-sm pr-10"
                            placeholder="Select date">
                    </div>
                </div>
                <div class="col-span-full mt-4">
                    <button type="submit"
                        class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-3 rounded">
                        Submit
                    </button>
                </div>
            </form>
            <div id="successMessage" class="hidden mt-4 px-4 py-2 bg-green-500 text-white rounded-md shadow-md text-center font-semibold transition-all duration-300 opacity-0">
                Task submitted successfully!
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
    <script>
        flatpickr("#datepicker", {
            dateFormat: "Y-m-d",
            minDate: "today",
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('taskForm');
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                document.querySelectorAll('.error').forEach(el => el.remove());
                document.getElementById('successMessage').classList.add('hidden');
                document.getElementById('successMessage').style.opacity = '0';

                const title = document.getElementById('title').value.trim();
                const description = document.getElementById('description').value.trim();
                const due_date = document.getElementById('datepicker').value.trim();

                let isValid = true;

                if (!title) {
                    isValid = false;
                    const errorElement = createErrorElement("Title is required.");
                    document.getElementById('title').after(errorElement);
                }

                if (!description) {
                    isValid = false;
                    const errorElement = createErrorElement("Description is required.");
                    document.getElementById('description').after(errorElement);
                }

                if (!due_date) {
                    isValid = false;
                    const errorElement = createErrorElement("Due date is required.");
                    document.getElementById('datepicker').after(errorElement);
                }

                if (!isValid) {
                    return;
                }

                const formData = new FormData(form);

                fetch('/tasks', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.errors) {
                            for (const field in data.errors) {
                                const errorMessage = data.errors[field][0];
                                const inputElement = document.getElementById(field);
                                const errorElement = document.createElement('span');
                                errorElement.classList.add('error', 'text-red-500', 'text-sm');
                                errorElement.textContent = errorMessage;
                                inputElement.after(errorElement);
                            }
                        } else {
                            const successMessage = document.getElementById('successMessage');
                            successMessage.textContent = data.message;
                            successMessage.classList.remove('hidden');
                            successMessage.style.opacity = '1';

                            // Hide the success message after 3 seconds
                            setTimeout(() => {
                                successMessage.style.opacity = '0';
                                setTimeout(() => successMessage.classList.add('hidden'), 500);
                            }, 3000);

                            form.reset();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        function createErrorElement(message) {
            const errorElement = document.createElement('span');
            errorElement.classList.add('error', 'text-red-500', 'text-sm');
            errorElement.textContent = message;
            return errorElement;
        }
    </script>
@endsection

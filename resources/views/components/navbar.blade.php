<nav class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 shadow-lg p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo Section -->
        <a href="#" class="text-white font-bold text-xl tracking-wider hover:opacity-90">
            TaskManager
        </a>

        <!-- Hamburger Icon -->
        <button id="hamburger" class="md:hidden text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Navigation Links -->
        <ul id="nav-links" class="hidden md:flex space-x-6">
            <li>
                <a href="{{ route('tasks.index') }}" class="text-white text-lg hover:text-orange-400 transition duration-300">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('tasks.create') }}" class="text-white text-lg hover:text-orange-400 transition duration-300">
                    Create Task
                </a>
            </li>
        </ul>
    </div>

    <!-- Mobile Navigation Links -->
    <ul id="mobile-nav-links" class="md:hidden hidden flex-col space-y-2 mt-2">
        <li>
            <a href="{{ route('tasks.index') }}" class="text-white text-lg hover:text-orange-400 transition duration-300">
                Home
            </a>
        </li>
        <li>
            <a href="{{ route('tasks.create') }}" class="text-white text-lg hover:text-orange-400 transition duration-300">
                Create Task
            </a>
        </li>
    </ul>
</nav>

<script>
    const hamburger = document.getElementById("hamburger");
    const mobileNavLinks = document.getElementById("mobile-nav-links");

    hamburger.addEventListener("click", () => {
        mobileNavLinks.classList.toggle("hidden");
    });
</script>

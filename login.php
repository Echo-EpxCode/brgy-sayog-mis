<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Barangay Sayog MIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .role-btn.active {
            background-color: #059669;
            /* emerald-600 */
            color: white;
            border-color: #059669;
        }
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    <div class="header"></div>

    <!-- MAIN CONTENT -->
    <main class="bg-gray-50 h-screen flex overflow-hidden">
        <!-- LEFT SIDE: Branding & Visuals -->
        <div class="hidden md:flex w-1/2 bg-emerald-600 flex-col justify-between p-12 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-emerald-500 opacity-20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-teal-400 opacity-20 blur-3xl"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span class="text-2xl font-bold tracking-tight">Barangay Sayog MIS</span>
                </div>
                <h1 class="text-4xl font-bold leading-tight mb-4">
                    Digital Governance for a Better Community.
                </h1>
                <p class="text-emerald-100 text-lg max-w-md">
                    Access the Management Information System to manage records, services, and community data efficiently.
                </p>
            </div>

            <div class="relative z-10 text-sm text-emerald-200">
                &copy; 2024 Barangay Sayog. All rights reserved.
            </div>
        </div>

        <!-- RIGHT SIDE: Login Form -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-8 bg-white">

            <div class="w-full max-w-md space-y-8">

                <!-- Mobile Header (Visible only on small screens) -->
                <div class="md:hidden flex flex-col items-center mb-8">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="text-2xl font-bold text-gray-800">Barangay Sayog</span>
                    </div>
                </div>

                <div class="text-center md:text-left">
                    <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                    <p class="mt-2 text-sm text-gray-600">Please sign in to continue to your dashboard.</p>
                </div>

                <!-- Role Selection (Segmented Control) -->
                <div class="bg-gray-100 p-1 rounded-lg flex mb-6">
                    <button type="button" class="role-btn active flex-1 py-2 text-sm font-medium rounded-md transition-all duration-200 focus:outline-none" onclick="selectRole('secretary', this)">
                        Secretary
                    </button>
                    <button type="button" class="role-btn flex-1 py-2 text-sm font-medium rounded-md text-gray-600 transition-all duration-200 focus:outline-none" onclick="selectRole('resident', this)">
                        Resident
                    </button>
                </div>
                <!-- Hidden Input to store the selected role for the form submission -->
                <input type="hidden" name="role" id="selected_role" value="secretary">

                <form action="" method="POST" class="mt-8 space-y-6">
                    <div class="space-y-4">
                        <!-- Username Input -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username / Email</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input id="username" name="username" type="text" required class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-colors" placeholder="Enter your username">
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <input id="password" name="password" type="password" required class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-colors" placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <input id="confirm_password" name="confirm_password" type="password" required class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-colors" placeholder="••••••••">
                            </div>
                            <!-- Error Message Display (Client-Side) -->
                            <p id="password_error" class="mt-1 text-xs text-red-500 hidden">Passwords do not match. Please try again.</p>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all shadow-md hover:shadow-lg">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-emerald-400 group-hover:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                            </span>
                            Sign In
                        </button>
                    </div>
                </form>

                <div class="text-center mt-6">
                    <p class="text-sm text-gray-500">
                        New to the system? <a href="register.php" class="font-medium text-emerald-600 hover:text-emerald-500">Register here</a>
                    </p>
                </div>
            </div>
        </div>

    </main>
    <!-- MAIN END -->


    <!-- Scripts -->
    <script>
        // Role Selection Toggle
        function selectRole(role, element) {
            document.getElementById('selected_role').value = role;
            const buttons = document.querySelectorAll('.role-btn');
            buttons.forEach(btn => {
                btn.classList.remove('active', 'bg-emerald-600', 'text-white', 'border-emerald-600');
                btn.classList.add('text-gray-600');
            });
            element.classList.add('active');
            element.classList.remove('text-gray-600');
        }

        // Password Match Validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const errorElement = document.getElementById('password_error');

            if (password !== confirmPassword) {
                e.preventDefault();
                errorElement.classList.remove('hidden');
            } else {
                errorElement.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Barangay Sayog MIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- HEADER START -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="font-bold text-xl text-gray-800">Barangay Sayog MIS</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="index.php" class="text-sm font-medium text-gray-600 hover:text-emerald-600 transition-colors">Home</a>
                    <a href="login.php" class="text-sm font-medium text-gray-600 hover:text-emerald-600 transition-colors">Login</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- HEADER END -->

    <!-- MAIN CONTENT -->
    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">Create Your Barangay ID</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Register to access digital services, request clearances, and manage your records.
                </p>
            </div>

            <!-- Registration Form Card -->
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-lg sm:px-10 border border-gray-100">
                <form action="" method="POST" class="space-y-8">

                    <!-- SECTION 1: Personal Information -->
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Personal Information
                        </h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                            <!-- First Name -->
                            <div class="sm:col-span-3">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <input type="text" name="first_name" id="first_name" required class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>

                            <!-- Middle Name -->
                            <div class="sm:col-span-3">
                                <label for="middle_name" class="block text-sm font-medium text-gray-700">Middle Name</label>
                                <div class="mt-1">
                                    <input type="text" name="middle_name" id="middle_name" class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="sm:col-span-3">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <input type="text" name="last_name" id="last_name" required class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>

                            <!-- Suffix -->
                            <div class="sm:col-span-3">
                                <label for="suffix" class="block text-sm font-medium text-gray-700">Suffix</label>
                                <div class="mt-1">
                                    <select id="suffix" name="suffix" class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border bg-white">
                                        <option value="">None</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Date of Birth -->
                            <div class="sm:col-span-3">
                                <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <input type="date" name="dob" id="dob" required class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>

                            <!-- Sex -->
                            <div class="sm:col-span-3">
                                <label for="sex" class="block text-sm font-medium text-gray-700">Sex <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <select id="sex" name="sex" required class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border bg-white">
                                        <option value="">Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Civil Status -->
                            <div class="sm:col-span-3">
                                <label for="civil_status" class="block text-sm font-medium text-gray-700">Civil Status <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <select id="civil_status" name="civil_status" required class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border bg-white">
                                        <option value="">Select Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Separated">Separated</option>
                                        <option value="Divorced">Divorced</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Religion -->
                            <div class="sm:col-span-3">
                                <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                                <div class="mt-1">
                                    <input type="text" name="religion" id="religion" class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: Contact & Address -->
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Contact & Address
                        </h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                            <!-- Email -->
                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <input type="email" name="email" id="email" required class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>

                            <!-- Mobile Number -->
                            <div class="sm:col-span-3">
                                <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile Number <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <input type="tel" name="mobile" id="mobile" required placeholder="0912 345 6789" class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>

                            <!-- Full Address -->
                            <div class="sm:col-span-6">
                                <label for="address" class="block text-sm font-medium text-gray-700">Full Address <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <textarea id="address" name="address" rows="3" required class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border"></textarea>
                                    <p class="mt-1 text-xs text-gray-500">Street, Barangay, City, Province, Zip Code</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: Account Credentials -->
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            Account Security
                        </h3>
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">

                            <!-- Username -->
                            <div class="sm:col-span-3">
                                <label for="username" class="block text-sm font-medium text-gray-700">Username <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <input type="text" name="username" id="username" required class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="sm:col-span-3">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative">
                                    <input type="password" name="password" id="password" required class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border pr-10">
                                    <button type="button" onclick="togglePassword('password', 'eye-icon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <svg id="eye-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="sm:col-span-6">
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative">
                                    <input type="password" name="confirm_password" id="confirm_password" required class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 border pr-10">
                                    <button type="button" onclick="togglePassword('confirm_password', 'eye-icon-confirm')" class="absolute inset-y-0 right-0 pr-3
                                                                        <button type=" button" onclick="togglePassword('confirm_password', 'eye-icon-confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                        <svg id="eye-icon-confirm" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                            Create Account
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Links -->
            <div class="text-center text-sm text-gray-500 mt-6">
                <p>Already have an account? <a href="login.php" class="font-medium text-emerald-600 hover:text-emerald-500">Sign In</a></p>
            </div>
        </div>
    </main>

    <!-- FOOTER START -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-400">
                &copy; 2024 Barangay Sayog MIS. All rights reserved.
            </p>
        </div>
    </footer>
    <!-- FOOTER END -->

    <!-- Scripts -->
    <script>
        // Toggle Password Visibility
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                // Change icon to 'eye-off'
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                input.type = "password";
                // Change icon back to 'eye'
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

        // Password Match Validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert("Passwords do not match! Please try again.");
            }
        });
    </script>
</body>

</html>
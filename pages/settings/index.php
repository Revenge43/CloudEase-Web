<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body class="h-screen w-screen bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white flex flex-col h-full">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Cloudease</h1>
            </div>
            <?= $_SESSION['SidebarComponent'] ?>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-100">
            <header class="flex items-center justify-between p-6 bg-white shadow-md">
                <h2 class="text-2xl font-semibold text-gray-700">Settings</h2>
            </header>

            <!-- Settings Content -->
            <div class="p-6 mt-6 bg-white rounded-lg shadow-md space-y-8">
                <!-- Profile Section -->
                <section>
                    <h3 class="text-xl font-semibold text-gray-800">Profile Settings</h3>
                    <form action="update_profile.php" method="POST" class="mt-4">
                        <div class="mb-4">
                            <label for="username" class="block text-gray-700 font-medium">Username</label>
                            <input type="text" id="username" name="username"
                                   class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter your username" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium">Email</label>
                            <input type="email" id="email" name="email"
                                   class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter your email address" required>
                        </div>
                        <button type="submit"
                                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Update Profile
                        </button>
                    </form>
                </section>

                <!-- Password Section -->
                <section>
                    <h3 class="text-xl font-semibold text-gray-800">Change Password</h3>
                    <form action="change_password.php" method="POST" class="mt-4">
                        <div class="mb-4">
                            <label for="current-password" class="block text-gray-700 font-medium">Current Password</label>
                            <input type="password" id="current-password" name="current_password"
                                   class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter your current password" required>
                        </div>
                        <div class="mb-4">
                            <label for="new-password" class="block text-gray-700 font-medium">New Password</label>
                            <input type="password" id="new-password" name="new_password"
                                   class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter your new password" required>
                        </div>
                        <button type="submit"
                                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Change Password
                        </button>
                    </form>
                </section>

                <!-- Preferences Section -->
                <!-- <section>
                    <h3 class="text-xl font-semibold text-gray-800">Account Preferences</h3>
                    <form action="update_preferences.php" method="POST" class="mt-4">
                        <div class="mb-4">
                            <label for="notifications" class="block text-gray-700 font-medium">Email Notifications</label>
                            <select id="notifications" name="notifications"
                                    class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="enabled">Enabled</option>
                                <option value="disabled">Disabled</option>
                            </select>
                        </div>
                        <button type="submit"
                                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Save Preferences
                        </button>
                    </form>
                </section> -->
            </div>
        </main>
    </div>
</body>
</html>
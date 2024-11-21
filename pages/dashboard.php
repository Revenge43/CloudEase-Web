<?php
session_start();
if (!isset($_SESSION['access_token'])) {
    header("Location: forbidden.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloudease - Dashboard</title>
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
        <main class="flex-1">
            <!-- Top Navbar -->

            <?= $_SESSION['HeaderComponent'] ?>

            <!-- Dashboard Content -->
            <div class="p-6 bg-gray-100">
                <!-- Welcome Message -->
                <div class="mb-6 bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-semibold text-gray-700">Welcome to Cloudease, <?= $_SESSION['user']['email'] ?>!</h2>
                    <p class="mt-2 text-gray-600">Here’s an overview of your recent activity and progress.</p>
                </div>

                <!-- Overview Section -->
                <div class="grid gap-6 mb-6 lg:grid-cols-3">
                    <!-- Courses Overview -->
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h3 class="text-lg font-semibold text-gray-700">Your Courses</h3>
                        <p class="mt-1 text-gray-600">5 active courses</p>
                        <a href="#" class="mt-4 inline-block text-blue-600 hover:underline">View all courses</a>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h3 class="text-lg font-semibold text-gray-700">Recent Activity</h3>
                        <ul class="mt-2 space-y-2 text-gray-600">
                            <li>Submitted assignment for Math 101</li>
                            <li>Joined group discussion in Science</li>
                            <li>New message from instructor</li>
                        </ul>
                    </div>

                    <!-- Progress Tracking -->
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h3 class="text-lg font-semibold text-gray-700">Progress</h3>
                        <p class="mt-1 text-gray-600">Overall completion: 65%</p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                        </div>
                        <a href="#" class="mt-4 inline-block text-blue-600 hover:underline">View detailed progress</a>
                    </div>
                </div>

                <!-- Additional Content -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Announcements</h3>
                    <ul class="mt-4 space-y-2 text-gray-600">
                        <li>New course material available for History 201.</li>
                        <li>Final exams scheduled for the last week of November.</li>
                        <li>Don't forget to check the latest assignments!</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
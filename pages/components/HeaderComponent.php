<?php

namespace Components;

class HeaderComponent
{

    /**
     * @return string $html
     */
    public static function render()
    {
        return <<<HTML
            <header class="flex items-center justify-between p-6 bg-white shadow-md">
                    <div class="flex items-center space-x-4">
                        <input type="text" placeholder="Search..."
                            class="px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="flex items-center space-x-2 text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                <img class="w-8 h-8 rounded-full" src="https://via.placeholder.com/40" alt="Profile Picture">
                                <span>{$_SESSION['user']['name']}</span>
                            </button>
                            <div class="absolute right-0 z-10 hidden mt-2 w-48 py-2 bg-white rounded-md shadow-xl" data-dropdown-toggle="profileDropdown">
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    </div>
                </header>
            HTML;
    }
}

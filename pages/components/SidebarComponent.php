<?php
namespace Components;

class SidebarComponent
{
    /**
     * @var array $routes
     */
    private static $routes = [
        '/pages/dashboard.php' => 'Dashboard',
        '/pages/course/index.php' => 'Courses',
        '/pages/discussion/index.php' => 'Discussions',
        '/pages/assignment/index.php' => 'Assignments',
        '/logout.php' => 'Logout',
    ];

    /**
     * @return string $html
     */
    public static function render()
    {
        $html = '<nav class="flex-1 px-4 py-2">';

        foreach (self::$routes as $route => $label) {
            $html .= <<<HTML
                        <a href="{$route}" class="block py-2 px-4 mb-2 text-blue-100 rounded hover:bg-blue-700">{$label}</a>
                    HTML;
        }

        $html .= '</nav>';

        return $html;
    }
}

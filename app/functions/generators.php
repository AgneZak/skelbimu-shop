<?php


/**
 *
 * Returns an array for navigation,
 * with name and links
 *
 * @return string[]
 */
function nav(): array
{
    $nav = ['/index.php' => 'Home'];

    if (is_logged_in()) {
        return $nav + [
            '/admin/add.php' => 'Add Stuff',
            '/admin/my.php' => 'My Stuff',
            '/admin/cart.php' => 'My Order',
            '/logout.php' => 'Logout',
        ];
    } else {
        return $nav + [
            '/register.php' => 'Register',
            '/login.php' => 'Login',
        ];
    }
}
<?php

/*
 * Set active class to menu and sub menu
 * will add the active class to .dropdown for the routes: /page and any child routes /page/*
 * e.g /page/child-1, /page/child-2, /page/child-3
 * for parent: <li class="dropdown {{ set_active(['page', 'page/*']) }}">
 * for child: <li class="{{ set_active(['page/child-1']) }}">
 *
 *
 * @param string $path
 * @param string $active
 * @return string default 'active'
 */
function set_active($path, $active = 'active') {
    return call_user_func_array('Request::is', (array)$path) ? $active : '';
}
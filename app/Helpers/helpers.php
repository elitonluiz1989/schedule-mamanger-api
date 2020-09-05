<?php
if (! function_exists('modules_path')) {
    /**
     * Get the path to the modules folder.
     *
     * @param  string  $path
     * @return string
     */
    function modules_path($path = '')
    {
        $path = 'modules' . DIRECTORY_SEPARATOR . $path;

        return app()->basePath($path);
    }
}

<?php

if (!function_exists('ewb')) {
    /**
     * Get EasyWebpackBuild instance
     * @return \Sabatino\EasyWebpackBuild\EasyWebpackBuild
     */
    function ewb()
    {
        return app(\Sabatino\EasyWebpackBuild\EasyWebpackBuild::class);
    }
}

<?php

if (!function_exists('ewb')) {
    /**
     * Get EasyWebpackBuild instance
     * @return \Sabatino\EasyWebpackBuild\EasyWebpackBuild
     */
    function ewb($manifestFile = 'manifest.json', $hmrFile = 'w_hmr', $devServerUrl = 'http://localhost:8080')
    {
        $ewb = app(\Sabatino\EasyWebpackBuild\EasyWebpackBuild::class);
        $ewb->setup($manifestFile, $hmrFile, $devServerUrl);
        return $ewb;
    }
}

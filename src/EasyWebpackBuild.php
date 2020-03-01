<?php

namespace Sabatino\EasyWebpackBuild;

class EasyWebpackBuild
{
    public function css($name)
    {
        $name = static::asset($name);
        if (static::isHmr()) {
            $name = str_replace('css', 'js', $name);
            return '<script src="' . $name . '"></script>';
        }
        return '<link rel="stylesheet" type="text/css" href="' . $name . '">';
    }

    public function isHmr() {
        if (file_exists(storage_path('w_hmr'))) {
            return true;
        }
        return false;
    }

    public function asset($key)
    {
        if (static::isHmr()) {
            return 'http://localhost:8080' . $key;
        }
        static $manifest = false;
        $manifestPath = public_path('manifest.json');
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
        } else {
            throw new \Exception('Manifest not found');
        }
        if ($manifest) {
            return $manifest[$key];
        }
        throw new \Exception('File ' . $key . ' not found');
    }

    public function scripts($productionScripts, $hmrScripts = []) {
        if (empty($hmrScripts)) {
            $hmrScripts = $productionScripts;
        }
        $scriptsToRender = static::isHmr() ? $hmrScripts : $productionScripts;
        collect($scriptsToRender)->each(function($script) {
            echo '<script src="' . static::asset($script) . '"></script>';
        });
        if (static::isHmr()) {
            echo "<script>console.log('%c Running in HMR Mode', 'background: #000; color: #bada55');</script>";
        }
    }

}

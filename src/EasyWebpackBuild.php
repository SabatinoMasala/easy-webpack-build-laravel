<?php

namespace Sabatino\EasyWebpackBuild;

class EasyWebpackBuild
{

    public $manifestFile;
    public $devServerUrl;
    public $hmrFile;

    public function setup($manifestFile, $hmrFile, $devServerUrl)
    {
        $this->manifestFile = $manifestFile;
        $this->hmrFile = $hmrFile;
        $this->devServerUrl = $devServerUrl;
    }

    public function css($name = '/dist/css/styles.css')
    {
        $name = static::asset($name);
        if (static::isHmr()) {
            $name = str_replace('css', 'js', $name);
            return '<script src="' . $name . '"></script>';
        }
        $domain = config('ewb.domain', '');
        $style = $domain . $name;
        return '<link rel="stylesheet" type="text/css" href="' . $style . '">';
    }

    public function isHmr() {
        if (file_exists(storage_path($this->hmrFile))) {
            return true;
        }
        return false;
    }

    public function asset($key)
    {
        if (static::isHmr()) {
            return $this->devServerUrl . $key;
        }
        static $manifest = false;
        $manifestPath = public_path($this->manifestFile);
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
        } else {
            throw new \Exception('Manifest not found: ' . $manifestPath);
        }
        if ($manifest) {
            return $manifest[$key];
        }
        throw new \Exception('File ' . $key . ' not found');
    }

    public function scripts($productionScripts = ['/dist/js/bundle.js', '/dist/js/manifest.js', '/dist/js/vendor.js'], $hmrScripts = ['/dist/js/bundle.js']) {
        if (empty($hmrScripts)) {
            $hmrScripts = $productionScripts;
        }
        $scriptsToRender = static::isHmr() ? $hmrScripts : $productionScripts;
        collect($scriptsToRender)->each(function($script) {
            $domain = config('ewb.domain', '');
            $script = static::asset($script);
            $script = $domain . $script;
            echo '<script src="' . $script . '"></script>';
        });
        if (static::isHmr()) {
            echo "<script>console.log('%c Running in HMR Mode', 'background: #000; color: #bada55');</script>";
        }
    }

    public function scriptsInDir($directory = 'dist') {
        $this->scripts([
            '/' . $directory . '/js/bundle.js',
            '/' . $directory . '/js/manifest.js',
            '/' . $directory . '/js/vendor.js'
        ], [
            '/' . $directory . '/js/bundle.js'
        ]);
    }

}

<?php

if (!function_exists('asset_versioned')) {
    function asset_versioned($path) {
        $realPath = public_path($path);
        $version = file_exists($realPath) ? filemtime($realPath) : time();
        return asset($path) . '?v=' . $version;
    }
}

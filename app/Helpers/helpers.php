<?php

if (!function_exists('static_asset'))
{
    function static_asset($path)
    {
        return app('url')->asset('public/' . $path);
    }
}

/* ===============================
YOUTUBE EMBED URL HELPER
================================ */

if (!function_exists('youtube_embed'))
{
    function youtube_embed($url)
    {
        preg_match(
            '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i',
            $url,
            $match
        );

        return isset($match[1])
        ? 'https://www.youtube.com/embed/' . $match[1]
        : null;
    }
}

<?php

namespace BrainMaestro\Tldr;

final class Page
{
    const BASE_URL = 'https://raw.githubusercontent.com/tldr-pages/tldr/master/pages/';

    /**
     * Get the page for the platform in the local cache or download it if it does not exist
     *
     * @param string $platform
     * @param string $page
     * @return string
     */
    public static function get(string $platform, string $page): string
    {
        $cacheDir = self::getCacheDir('/pages') . '/' . $platform;
        $pageFile = "{$cacheDir}/{$page}.md";

        if (! is_dir($cacheDir)) {
            mkdir($cacheDir, 0700, true);
        }

        if (! file_exists($pageFile)) {
            $contents = @file_get_contents(self::BASE_URL . "{$platform}/{$page}.md");
            if (! $contents) {
                return '';
            }

            file_put_contents($pageFile, $contents);
        } else {
            $contents = file_get_contents($pageFile);
        }

        return self::format($contents);
    }

    /**
     * Clears the entire tldr cache
     */
    public static function clearCache()
    {
        $cacheDir = self::getCacheDir();
        $statusCode = 1;

        if (is_dir($cacheDir)) {
            passthru("rm -r {$cacheDir}", $statusCode);
        }

        return $statusCode;
    }

    /**
     * Updates the local pages
     */
    public static function update()
    {
        $cacheDir = self::getCacheDir('/pages');

        if (! is_dir($cacheDir)) {
            return;
        }

        $platforms = array_slice(scandir($cacheDir), 2);

        foreach ($platforms as $platform) {
            $files = array_slice(scandir("{$cacheDir}/{$platform}"), 2);
            foreach ($files as $file) {
                unlink("{$cacheDir}/{$platform}/{$file}");
                Page::get($platform, $file);
            }
        }
    }

    private static function format(string $content): string
    {
        $rules = [
            // delete title of page that starts with #
            '/^# .*\n\n/' => '',
            // remove '>' from short description
            '/^> (.+)/m' => '$1',
            // remove extra newline
            '/:\n$/m' => ':',
            // color example command usage description
            '/^(- .+)/m' => '<info>$1</info>',
            // color all text in example command usage
            '/^`(.+)`$/m' => '<fg=cyan>  $1</>',
            // color all other backticked text
            '/`(.+)`/m' => '<fg=yellow>$1</>',
            // remove coloring from content between braces
            '/{{(.+?)}}/' => '</>$1</>',
        ];

        foreach ($rules as $pattern => $replacement) {
            $content = preg_replace($pattern, $replacement, $content);
        }

        return $content;
    }

    private static function getCacheDir(string $subDir = ''): string
    {
        return "{$_SERVER['HOME']}/.tldr".$subDir;
    }
}

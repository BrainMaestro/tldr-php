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
        $cacheDir = "{$_SERVER['HOME']}/.tldr/{$platform}";
        $pageFile = "{$cacheDir}/{$page}.md";

        if (! is_dir($cacheDir)) {
            mkdir($cacheDir, 0700, true);
        }

        if (! file_exists($pageFile)) {
            $contents = file_get_contents(self::BASE_URL . "{$platform}/{$page}.md");
            file_put_contents($pageFile, $contents);
        } else {
            $contents = file_get_contents($pageFile);
        }

        return self::format($contents);
    }

    private static function format(string $content): string
    {
        $rules = [
            '/# (.+)\n\n/' => '',
            '/> (.+)/' => '$1',
            '/:\n/' => ':',
            '/(- .+)/' => '<info>$1</info>',
            '/`(.+)`/' => '  $1',
            '/(\n {2}\w++)/' => '<fg=cyan>$1</>',
            '/( -+\S+)/' => '<fg=yellow>$1</>',
            '/{{(.+?)}}/' => '</>$1',
        ];

        foreach ($rules as $pattern => $replacement) {
            $content = preg_replace($pattern, $replacement, $content);
        }

        return $content;
    }
}

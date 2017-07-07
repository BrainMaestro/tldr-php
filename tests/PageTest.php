<?php

namespace BrainMaestro\Tldr\Tests;

use BrainMaestro\Tldr\Page;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    /**
     * @test
     */
    public function it_gets_a_tldr_page_that_does_not_exist_locally_and_saves_it()
    {
        $path = "{$_SERVER['HOME']}/.tldr/common/tar.md";
        if (file_exists($path)) {
            unlink($path);
        }

        $this->assertFalse(file_exists($path));
        $this->assertNotEmpty(Page::get('common', 'tar'));
        $this->assertTrue(file_exists($path));
    }

    /**
     * @test
     */
    public function it_returns_an_empty_result_for_a_tldr_page_that_does_not_exist_online()
    {
        $this->assertEmpty(Page::get('common', 'does-not-exist'));
    }

    /**
     * @test
     */
    public function it_deletes_the_entire_local_cache()
    {
        $path = "{$_SERVER['HOME']}/.tldr/common/tar.md";
        Page::get('common', 'tar');

        $this->assertTrue(file_exists($path));
        $this->assertEquals(0, Page::clearCache());
        $this->assertFalse(file_exists($path));
    }
}

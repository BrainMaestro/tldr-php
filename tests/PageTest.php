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
}

<?php

namespace BrainMaestro\Tldr\Tests;

use BrainMaestro\Tldr\Commands\Tldr;
use BrainMaestro\Tldr\Page;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class TldrTest extends TestCase
{
    private $commandTester;

    public function setUp()
    {
        $this->commandTester = new CommandTester(new Tldr);
    }

    /**
     * @test
     */
    public function it_outputs_the_content_for_a_valid_page()
    {
        $this->commandTester->execute(['page' => 'tar']);

        $this->assertNotEmpty($this->commandTester->getDisplay());
        $this->assertEquals(0, $this->commandTester->getStatusCode());
    }

    /**
     * @test
     */
    public function it_fails_with_an_error_for_a_page_that_does_not_exist()
    {
        $this->commandTester->execute(['page' => 'does-not-exist']);

        $this->assertNotEmpty($this->commandTester->getDisplay());
        $this->assertEquals('does-not-exist command does not exist on the common platform', trim($this->commandTester->getDisplay()));
        $this->assertEquals(1, $this->commandTester->getStatusCode());
    }

    /**
     * @test
     */
    public function it_fails_with_an_error_if_no_page_is_specified()
    {
        $this->commandTester->execute([]);

        $this->assertNotEmpty($this->commandTester->getDisplay());
        $this->assertEquals('You must provide a command', trim($this->commandTester->getDisplay()));
        $this->assertEquals(1, $this->commandTester->getStatusCode());
    }

    /**
     * @test
     */
    public function it_clears_the_entire_local_cache()
    {
        Page::get('common', 'tar');
        $this->commandTester->execute(['--clear-cache' => true]);

        $this->assertEmpty($this->commandTester->getDisplay());
        $this->assertEquals(0, $this->commandTester->getStatusCode());
    }

    /**
     * @test
     */
    public function it_fails_if_there_is_no_cache_to_clear()
    {
        Page::clearCache();
        $this->commandTester->execute(['--clear-cache' => true]);

        $this->assertEmpty($this->commandTester->getDisplay());
        $this->assertNotEquals(0, $this->commandTester->getStatusCode());
    }

    /**
     * @test
     * See: https://github.com/BrainMaestro/tldr-php/issues/1
     */
    public function it_gets_a_tldr_page_that_has_a_mid_sentence_dash_character_without_failing()
    {
        $this->commandTester->execute(['page' => 'curl']);

        $this->assertNotEmpty($this->commandTester->getDisplay());
        $this->assertEquals(0, $this->commandTester->getStatusCode());
    }
}

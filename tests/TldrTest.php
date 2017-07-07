<?php

namespace BrainMaestro\Tldr\Tests;

use BrainMaestro\Tldr\Commands\Tldr;
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
}

<?php namespace RockPaperScissorsSpockLizardTest;

use PHPUnit\Framework\TestCase;
use Jarrett\RockPaperScissorsSpockLizard;

class RockPaperScissorsSpockLizardTest extends TestCase
{
    protected $game;

    public function setUp()
    {
        $this->game = new RockPaperScissorsSpockLizard();
    }

    /** @test */
    public function can_set_and_get_rounds()
    {
        $this->game->setRounds(3);

        $rounds = $this->game->getRounds();
        $this->assertEquals(3, $rounds);
    }
}
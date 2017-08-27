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
        $this->assertEquals(3, $rounds, 'Game returned invalid number of rounds');
    }

    /** @test */
    public function can_restart_the_game()
    {
        $this->game->setRounds(5);
        $this->assertEquals(5, $this->game->getRounds(), 'Game returned invalid number of rounds');

        // TODO make some plays, and test that those are erased too

        $this->game->restart();
        $this->assertEquals(0, $this->game->getRounds(), 'Game returned invalid number of rounds');
    }
}
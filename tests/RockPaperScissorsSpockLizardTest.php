<?php namespace RockPaperScissorsSpockLizardTest;

use Jarrett\RockPaperScissorsSpockLizardException;
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
    public function throws_exception_for_bad_set_round_values()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);
        $this->game->setRounds('bad value');
    }
    
    /** @test */
    public function throws_exception_for_invalid_plays()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);
        $this->game->restart();
        $this->game->play('');
    }
    
    /** @test */
    public function exception_object_output_strings()
    {
        try {
            $this->game->setRounds('bad value');
        } catch (RockPaperScissorsSpockLizardException $e) {
            $exception = $e;
        }
    
        ob_start();
        echo $exception;
        $exception_string = ob_get_clean();
    
        $this->assertNotEmpty($exception_string, 'Exception message should not be empty');
    }

    /** @test */
    public function can_restart_the_game()
    {
        $this->game->setRounds(5);
        $this->assertEquals(5, $this->game->getRounds(), 'Game returned invalid number of rounds');

        // TODO make some plays, and test that those are erased too

        $this->game->restart();
        $this->assertEquals(1, $this->game->getRounds(), 'Game returned invalid number of rounds');
    }
    
    /** @test */
    public function exception_thrown_for_set_rounds_when_locked()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);
        $this->game->restart();
        $this->game->setRounds(5, true);
        $this->game->setRounds(19);
    }
    
    /** @test */
    public function exception_thrown_for_invalid_type_for_set_round_lock()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);
        $this->game->setRounds(5, 'some value');
    }
    
    /** @test */
    public function receive_false_if_getting_players_before_setting_players()
    {
        $this->game->restart();
        $players = $this->game->getPlayers();
        
        $this->assertFalse($players, 'Getting players when none have been set should return false');
    }
    
}

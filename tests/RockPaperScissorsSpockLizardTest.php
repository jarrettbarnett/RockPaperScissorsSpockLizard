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
    
        $this->assertNotEmpty($exception, 'Exception message should not be empty');
    }
    
    /** @test */
    public function can_get_last_play()
    {
        $this->game->play('paper');
        $this->game->play('rock');
        
        $last_play = $this->game->getLastPlay();
        
        $this->assertEquals('rock', $last_play, 'Last play is invalid');
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

    /** @test */
    public function can_make_a_play()
    {
        $this->game->restart();
        $this->game->play('spock');

        $last_play = $this->game->getLastPlay();

        $this->assertEquals('spock', $last_play, 'Game returned invalid play for the last play');
    }
    
    /** @test */
    public function can_make_a_play_via_magic()
    {
        $this->game->restart();
        $this->game->playSpock();
        
        $last_play = $this->game->getLastPlay();
        
        $this->assertEquals('spock', $last_play, 'Game returned invalid play for last play');
    }
    
    /** @test */
    public function magic_play_fails_for_bad_plays()
    {
        $this->game->restart();
        $name = $this->game->randomMethodName('random');
        
        $this->assertEmpty($name);
    }
}

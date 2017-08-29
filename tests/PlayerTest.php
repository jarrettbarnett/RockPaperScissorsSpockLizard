<?php namespace RockPaperScissorsSpockLizardTest;

use PHPUnit\Framework\TestCase;
use Jarrett\RockPaperScissorsSpockLizard\Game;
use Jarrett\RockPaperScissorsSpockLizard\Player;
use Jarrett\RockPaperScissorsSpockLizardException;

class PlayerTest extends TestCase
{
    /** @test */
    public function can_set_name_via_methid()
    {
        $player = new Player();
        $player->setName('Jarrett');
        
        $name = $player->getName();
        $this->assertEquals('Jarrett', $name, 'Invalid name!');
    }
    
    /** @test */
    public function can_queue_a_play()
    {
        $player = new Player();
        $player->move('spock');
        
        $last_move = $player->getLastMove();
        
        $this->assertEquals('spock', key($last_move), 'Move was not queued!');
    }
    
    /** @test */
    public function can_get_move_history()
    {
        $player = new Player();
        $player->move('rock');
        
        $history = $player->getMoveHistory();
        
        $this->assertEquals('rock', key($history[0]), 'History is invalid');
    }
    
    /** @test */
    public function cannot_set_more_than_one_move_at_a_time()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);
        
        $player = new Player();
        $player->move('paper');
        $player->move('scissors');
    }

    /** @test */
    public function mark_last_move_as_played()
    {
        $player = new Player();
        $player->move('rock');

        $last_move = $player->getLastMove();
        $this->assertEquals(false, current($last_move), 'Last move not set correctly');

        $player->lastMoveIsPlayed();
        $last_move = $player->getLastMove();
        $this->assertEquals(true, current($last_move), 'Last move was not marked as played');
    }

    /** @test */
    public function exception_thrown_if_move_empty()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);

        // set empty move
        $player1 = new Player();
        $player1->move('');

        $player2 = new Player();
        $player2->move('rock');

        $game = new Game();

        $game->addPlayers($player1, $player2)
              ->play();
    }
}
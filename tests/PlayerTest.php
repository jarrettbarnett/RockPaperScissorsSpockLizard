<?php namespace RockPaperScissorsSpockLizardTest;

use PHPUnit\Framework\TestCase;
use Jarrett\RockPaperScissorsSpockLizardException;
use Jarrett\RockPaperScissorsSpockLizard\Player;

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
}
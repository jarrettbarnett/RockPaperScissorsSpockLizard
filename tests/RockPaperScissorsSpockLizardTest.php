<?php namespace RockPaperScissorsSpockLizardTest;

use Jarrett\RockPaperScissorsSpockLizardException;
use PHPUnit\Framework\TestCase;
use Jarrett\RockPaperScissorsSpockLizard;
use Jarrett\RockPaperScissorsSpockLizard\Player;

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
    
    /** @test */
    public function can_add_players()
    {
        $player = new Player();
        $player->move('rock');
        
        $game = new RockPaperScissorsSpockLizard();
        $game->addPlayer($player);
        
        $players = $game->getPlayers();
        
        $this->assertNotEmpty($players);
    }
    
    /** @test */
    public function can_add_lots_of_players()
    {
        $game = new RockPaperScissorsSpockLizard();
        $players_to_add = 5;
        
        for ($i = $players_to_add; $i > 0; $i--)
        {
            $game->addPlayer((new Player));
        }
        
        $players = $game->getPlayers();
        
        $this->assertCount($players_to_add, $players, 'Not the right amount of players');
    }
    
    /** @test */
    public function can_add_lots_of_players_at_once()
    {
        $player1 = new Player();
        $player2 = new Player();
        $player3 = new Player();
        $player4 = new Player();
        
        $game = new RockPaperScissorsSpockLizard();
        $game->addPlayers($player1, $player2, $player3, $player4);
        
        $players = $game->getPlayers();
    
        $this->assertCount(4, $players, 'Not the right amount of players');
    }
    
    /** @test */
    public function restart_game_removes_players()
    {
        $game = new RockPaperScissorsSpockLizard();
        $game->addPlayer(new Player);
        
        $this->assertNotEmpty($game->getPlayers(), 'Player did not set properly!');
        
        $game->restart();
        $this->assertEmpty($game->getPlayers(), 'Players was not reset');
    }
    
    /** @test */
    public function exception_thrown_if_no_parameters_for_setting_players()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);
        
        $this->game->restart();
        
        $this->game->addPlayers();
    }
    
    /** @test */
    public function exception_thrown_if_one_or_more_parameters_not_player_instance()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);
        
        $this->game->restart();
        
        $player1 = new Player();
        $player2 = new Player();
        $player3 = 'a string and not a player object';
        
        $this->game->addPlayers($player1, $player2, $player3);
    }

    /** @test */
    public function exception_thrown_if_player_has_not_set_a_move()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);

        $game = new RockPaperScissorsSpockLizard();
        $player1 = new Player();
        $player2 = new Player();
        $player2->move('rock');

        $game->addPlayers($player1, $player2);
        $game->play();
    }

    /** @test */
    public function players_exist_when_added()
    {
        $game = new RockPaperScissorsSpockLizard();

        $human = new Player();
        $human->move('spock');

        $bot = new Player();
        $bot->isBot(true);
        $bot->move('rock');

        $game->addPlayers($human, $bot);


        $total = $game->getTotalPlayers();
        $this->assertNotEmpty($total);
    }
    
    /** @test */
    public function can_play_game_against_bot()
    {
        $game = new RockPaperScissorsSpockLizard();
        
        $human = new Player();
        $human->move('spock');

        $bot = new Player();
        $bot->isBot(true);

        $game->addPlayers($human, $bot);
        $game->play();

        $outcome = $game->getRoundOutcome();
        $this->assertNotEmpty($outcome, 'Outcome is empty');
    }

    /** @test */
    public function can_set_move_for_bot()
    {
        $game = new RockPaperScissorsSpockLizard();

        $human = new Player();
        $human->move('spock');

        $bot = new Player();
        $bot->isBot(true);
        $bot->move('rock');

        $game->addPlayers($human, $bot);
        $game->play();

        $outcome = $game->getRoundOutcome();
        $this->assertNotEmpty($outcome, 'Outcome is empty');
    }

    /** @test */
    public function players_can_tie()
    {
        $game = new RockPaperScissorsSpockLizard();

        $player1 = new Player();
        $player1->move('rock');

        $player2 = new Player();
        $player2->move('rock');

        $game->addPlayers($player1, $player2);
        $game->play();

        $outcome = $game->getOutcomes();
        $this->assertNotEmpty($outcome[0]['ties'], 'Ties outcome is empty');
    }

    /** @test */
    public function players_can_win()
    {
        $game = new RockPaperScissorsSpockLizard();

        $player1 = new Player();
        $player1->move('rock');

        $player2 = new Player();
        $player2->move('scissors');

        $game->addPlayers($player1, $player2);
        $game->play();

        $outcome = $game->getWinners();
        $this->assertNotEmpty($outcome, 'No winners!');

        $round_outcome = $game->getRoundWinners();
        $this->assertNotEmpty($round_outcome, 'No round winners!');
    }

    /** @test */
    public function exception_thrown_if_game_already_played()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);

        $game = new RockPaperScissorsSpockLizard();

        $player1 = new Player();
        $player1->move('rock');

        $player2 = new Player();
        $player2->move('scissors');

        $game->addPlayers($player1, $player2);
        $game->play();

        // play it again
        $game->play();
    }

    /** @test */
    public function exception_thrown_if_only_one_player()
    {
        $this->expectException(RockPaperScissorsSpockLizardException::class);

        $game = new RockPaperScissorsSpockLizard();

        $player1 = new Player();
        $player1->move('rock');

        $game->addPlayer($player1);
        $game->play();
    }
}

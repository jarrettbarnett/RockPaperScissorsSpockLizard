# RockPaperScissorsSpockLizard Game (in PHP)

A PHP class implementation of Rock Paper Scissors Spock Lizard as created by Sam Kass and Karen Bryla and popularized by "Big Bang Theory."

Install via composer:

    composer install jarrett/rockpaperscissorsspocklizard

and require composer autoloader

    require 'vendor/autoload.php';
    
### Basic Example:

    use Jarrett\RockPaperScissorsSpockLizard;
    use Jarrett\RockPaperScissorsSpockLizard\Player;

    // ...

    $player = new Player();
    $player->move('rock');
    
    $bot = new Player();
    $bot->isBot(true);
    
    $game = new RockPaperScissorsSpockLizard();
    $game->addPlayers($player, $bot)
         ->play();
         
    $outcome = $game->getOutcomes();    
    
### 2 Player Example:
    
    use Jarrett\RockPaperScissorsSpockLizard;
    use Jarrett\RockPaperScissorsSpockLizard\Player;
    
    // ...
    
    $player1 = new Player();
    $player1->move('rock');
    
    $player2 = new Player();
    $player2->move('scissors');
    
    $game = new RockpaperScissorsSpockLizard();
    $game->setRounds(3)
         ->addPlayers($player1, $player2);
         ->play();
    
    $outcome = $this->getOutcomes()
    

### Reference:

## Player( _string_ $player_name )

#### move( _string_ $move)
Set your move

#### setName()
Set player name. Can also be passed via the constructor. Generic "Player 1, 2, 3" will be used if name is empty.

#### getName()
Get player name.

#### getMoveHistory()
Get player's move history

#### getLastMove()
Get player's last move

## RockPaperScissorsSpockLizard()

#### play()
Play the round

#### restart()
Restarts the game

#### setRounds( _string_ $number, _bool_ $lock = false)
Set the number of rounds for this game. Default is 1 if not specified.
##### Parameters
###### $number _integer_
* The maximum number of rounds before a winner is chosen
###### $lock _bool_
* If _true_, don't allow the number of rounds to change for this game
* If _false_ (default), the maximum number of rounds can be changed during the game, even after a winner is determined.  

#### getRounds()
Returns all round results.

#### getOutcome()
Returns last round outcome.

#### addPlayer()
Add player to the game.

#### addPlayers()
Add multiple players to the game.

#### getPlayers()
Return players for game.

#### getTotalPlayers()
Returns the number of players playing

#### getRoundWinner()
Returns the player who won the last round.

#### getOutcomes()
Returns the outcomes for all players.

#### getWinners()
Returns the player who won the game.
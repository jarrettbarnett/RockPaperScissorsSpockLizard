[![Build Status](https://scrutinizer-ci.com/g/jarrettbarnett/RockPaperScissorsSpockLizard/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jarrettbarnett/RockPaperScissorsSpockLizard/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/jarrettbarnett/RockPaperScissorsSpockLizard/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/jarrettbarnett/RockPaperScissorsSpockLizard/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jarrettbarnett/RockPaperScissorsSpockLizard/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jarrettbarnett/RockPaperScissorsSpockLizard/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d72809d1-e357-4292-8c18-7e08a526fa42/small.png)](https://insight.sensiolabs.com/projects/d72809d1-e357-4292-8c18-7e08a526fa42)

# RockPaperScissorsSpockLizard Game (in PHP)

A PHP class implementation of Rock Paper Scissors Spock Lizard as created by Sam Kass and Karen Bryla and popularized by "Big Bang Theory."

**Add as many players (or bots) as you want. Then play them all against each other at the same time!**

Packagist can be found here: [jarrett/rockpaperscissorsspocklizard](https://packagist.org/packages/jarrett/rockpaperscissorsspocklizard)

### Getting Started

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
    
### 5 Player Example:
    
    use Jarrett\RockPaperScissorsSpockLizard;
    use Jarrett\RockPaperScissorsSpockLizard\Player;
    
    // ...
    
    // human
    $player1 = new Player();
    $player1->move('rock');
    
    // human
    $player2 = new Player();
    $player2->move('paper');
    
    // and 3 bots
    $player3 = new Player();
    $player4 = new Player();
    $player5 = new Player();
    
    $game = new RockpaperScissorsSpockLizard();
    $game->addPlayers($player1, $player2, $player3, $player4, $player5)
         ->play();
    
    // returns an array containing all wins, ties, and losses
    $outcomes = $this->getOutcomes()
    
... or just throw the player instantiation directly into the addPlayers() method

    $game = new RockpaperScissorsSpockLizard();
    $game->addPlayers($player1, $player2, (new Player), (new Player), (new Player))
             ->play();

### Class Method Reference:

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

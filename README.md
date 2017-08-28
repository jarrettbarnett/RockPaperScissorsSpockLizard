# RockPaperScissorsSpockLizard Game (in PHP)

A PHP class implementation of Rock Paper Scissors Spock Lizard as created by Sam Kass and Karen Bryla and popularized by "Big Bang Theory."

Install via composer:

    composer install jarrett/rockpaperscissorsspocklizard

or use without composer

    require 'src/RockPaperScissorsSpockLizard.php';
    
### Basic Example:
    
    $game = new RockpaperScissorsSpockLizard();
    $game->setRounds(3);
    
    $won = $game->play('spock');
    
    if ($won) {
        echo 'You won!';
    } else {
        echo 'You lost!';
    }

You can also play a move like this:

    $game->playSpock();

then retrieve the winner later:

    $won = $game->getRoundWinner();
    
or if the game is over:

    $final = $game->won();
    
### Advanced Example:

    $game = new RockpaperScissorsSpockLizard();
    $game->setRounds(3);
    
    $round1 = $game->playSpock;
    $round2 = $game->playPaper;
    $round3 = $game->playLizard;
    
    echo $game->won() ? 'Congrats, you won!' : 'So sad, you lost!';
    
### Reference:

#### setRounds( _string_ $number, _bool_ $lock = false)
Set the number of rounds for this game.
#### Parameters
###### $number _integer_
* The maximum number of rounds before a winner is chosen

###### $lock _bool_
* If _true_, don't allow the number of rounds to change for this game
* If _false_ (default), the maximum number of rounds can be changed during the game, even after a winner is determined.  

#### getLastPlay()
Returns the last play that was performed. 

#### restart()
Restarts the game

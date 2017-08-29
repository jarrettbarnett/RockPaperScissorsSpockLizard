<?php namespace Jarrett\RockPaperScissorsSpockLizard;

use Jarrett\RockPaperScissorsSpockLizardException;

/**
 * Class RockPaperScissorsSpockLizard
 *
 * @author Jarrett Barnett <hello@jarrettbarnett.com
 * @see http://www.samkass.com/theories/RPSSL.html
 */
class Game {

    const ROCK = 0;
    const PAPER = 1;
    const SCISSORS = 2;
    const SPOCK = 3;
    const LIZARD = 4;
    
    const DEFAULT_NUM_ROUNDS = 1;
    const DEFAULT_PLAYER_NAME_PREFIX = 'Player ';

    /**
     * Move labels
     * @var array
     */
    private $labels = [
        self::ROCK      => 'rock',
        self::PAPER     => 'paper',
        self::SCISSORS  => 'scissors',
        self::SPOCK     => 'spock',
        self::LIZARD    => 'lizard',
    ];

    /**
     * Outcomes
     * @var array
     */
    private $move_outcomes = [
        self::ROCK => [
            self::SCISSORS => 'crushes',
            self::LIZARD => 'crushes'
        ],
        self::PAPER => [
            self::ROCK => 'covers',
            self::SPOCK => 'disproves'
        ],
        self::SCISSORS => [
            self::PAPER => 'cuts',
            self::LIZARD => 'decapitates'
        ],
        self::SPOCK => [
            self::SCISSORS => 'smashes',
            self::ROCK => 'vaporizes'
        ],
        self::LIZARD => [
            self::SPOCK => 'poisons',
            self::PAPER => 'eats'
        ]
    ];
    
    /**
     * Game Outcome
     * @var $outcomes
     */
    protected $outcomes;
    
    /**
     * The number of rounds to play
     * @var $rounds
     */
    private $rounds = false;
    
    /**
     * Lock rounds from changing?
     * @var $rounds_lock
     */
    private $rounds_lock;
    
    /**
     * @var $last_outcome
     */
    private $last_outcome = false;
    
    /**
     * End of index for move outcomes
     * @var bool|int
     */
    private $moves_index_end = false;
    
    /**
     * @var $players - collection of players
     */
    protected $players = false;
    
    /**
     * RockPaperScissorsSpockLizard constructor.
     */
    public function __construct()
    {
        $this->setRounds(self::DEFAULT_NUM_ROUNDS);
        $this->moves_index_end = count(array_keys($this->move_outcomes)) - 1;
        
        return $this;
    }
    
    /**
     * Set Rounds
     *
     * @param $rounds
     * @param bool $lock
     * @return $this
     * @throws \Jarrett\RockPaperScissorsSpockLizardException
     */
    public function setRounds($rounds, $lock = false)
    {
        if ($this->rounds_lock === true)
        {
            throw new RockPaperScissorsSpockLizardException('The ability to set rounds has been locked for this game');
        }
        
        if (!is_numeric($rounds)) {
            throw new RockPaperScissorsSpockLizardException('Invalid value supplied for setRounds().');
        }
        
        if (!is_bool($lock)) {
            throw new RockPaperScissorsSpockLizardException('Lock parameter must be a boolean.');
        }
        
        $this->rounds_lock = (bool) $lock;
        $this->rounds = (int) $rounds;

        return $this;
    }

    /**
     * Get Rounds
     * @return mixed
     */
    public function getRounds()
    {
        return $this->rounds;
    }

    /**
     * Restart Game
     */
    public function restart()
    {
        $this->setRounds(self::DEFAULT_NUM_ROUNDS);
        $this->players = false;

        return $this;
    }
    
    /**
     * Play Move
     * @return bool
     * @throws \Jarrett\RockPaperScissorsSpockLizardException
     */
    public function play()
    {
        if ($this->getOutcomes() > 0 && $this->getRounds() >= count($this->getOutcomes())) {
            throw new RockPaperScissorsSpockLizardException('The game has already been played. Use getOutcomes() to see the game results!');
        }
        
        if (empty($this->getTotalPlayers())) {
            throw new RockPaperScissorsSpockLizardException('No players have been added to this game');
        }
        
        // if only 1 player has been added, add a computer player
        if ($this->getTotalPlayers() < 2) {
            throw new RockPaperScissorsSpockLizardException('This game requires at least 2 players');
        }
        
        $this->generateMovesForBots();
        $this->determineOutcome();
        
        return $this;
    }
    
    /**
     * Get Move's Index Value
     * @param $move
     * @return array|bool
     */
    protected function getMoveIndex($move)
    {
        return array_flip($this->labels)[key($move)];
    }
    
    /**
     * Get Random Move Using Mersenne Twister for even distribution
     * @return int
     */
    private function generateMove()
    {
        return $this->labels[mt_rand(0, $this->moves_index_end)];
    }
    
    /**
     * Generate Moves For Bots
     * @return $this
     */
    private function generateMovesForBots()
    {
        
        foreach ($this->getPlayers() as &$player) {

            $last_move = $player->getLastMoveIndex();

            // generate move for bots
            if ($player->isBot() && empty($last_move)) {
                $move = $this->generateMove();
                $player->move($move);
            }
        }
        
        return $this;
    }

    /**
     * Determine Outcome
     * @return string
     * @throws RockPaperScissorsSpockLizardException
     */
    private function determineOutcome()
    {
        $outcome = [];
        
        $players = $this->getPlayers();
        $opponents = $this->getPlayers();
        
        foreach ($players as $player) {
        
            foreach ($opponents as $opponent) {
    
                // dont play the player against themself
                if ($player->getId() === $opponent->getId())
                {
                    continue;
                }

                // move collection
                $player_move = $player->getLastMoveIndex();
                $opponent_move = $opponent->getLastMoveIndex();

                // verify moves have been set
                if (!is_array($player_move)) throw new RockPaperScissorsSpockLizardException($player->getName() . ' has not set a move!');
                if (!is_array($opponent_move)) throw new RockPaperScissorsSpockLizardException($opponent->getName() . ' has not set a move!');

                // move labels
                $player_move_label = ucfirst(key($player_move));
                $opponent_move_label = ucfirst(key($opponent_move));

                // map moves to an index
                $player_move_index = $this->getMoveIndex($player_move);
                $opponent_move_index = $this->getMoveIndex($opponent_move);

                // Exceptions
                if (!is_numeric($player_move_index)) throw new RockPaperScissorsSpockLizardException($player->getName() . ' made an illegal move!');
                if (!is_numeric($opponent_move_index)) throw new RockPaperScissorsSpockLizardException($opponent->getName() . ' made an illegal move!');
                if (current($player_move) === true) throw new RockPaperScissorsSpockLizardException($player->getName() . ' has already made this move!');
                if (current($opponent_move) === true) throw new RockPaperScissorsSpockLizardException($opponent->getName() . ' has already made this move!');

                // compare player with opponent
                if (isset($this->move_outcomes[$player_move_index][$opponent_move_index])) {
                    $outcome['winners'][] = [
                        'player' => $player,
                        'opponent' => $opponent,
                        'description' => $player_move_label . ' ' . $this->move_outcomes[$player_move_index][$opponent_move_index] . ' ' . $opponent_move_label
                    ];
                    $outcome['losers'][] = [
                        'player' => $opponent,
                        'opponent' => $player,
                        'description' => $player_move_label . ' ' . $this->move_outcomes[$player_move_index][$opponent_move_index] . ' ' . $opponent_move_label
                    ];
                } else if (isset($this->move_outcomes[$opponent_move_index][$player_move_index])) {
                    // dont do anything -- we just need to check this in order to determine whether a tie needs to be calculated
                } else {
                    // we just add the tie for the player since the opponent will be added to the ties on later iteration
                    $outcome['ties'][] = [
                        'player' => $player,
                        'opponent' => $opponent,
                        'description' => 'Both played ' . $player_move_label
                    ];
                }
            }
        }

        // mark last moves as played
        foreach ($players as $player) {
            $player->lastMoveIsPlayed();
        }
        
        $this->setOutcome($outcome);
        
        return $this->getRoundOutcome();
    }
    
    /**
     * Set Outcome
     * @param $outcome
     * @return $this
     */
    public function setOutcome($outcome)
    {
        $this->outcomes[] = $outcome;
        $this->last_outcome = $outcome;
        
        return $this;
    }
    
    /**
     * Get Round Outcome
     * @return bool
     */
    public function getRoundOutcome()
    {
        return $this->last_outcome;
    }
    
    /**
     * Add Player
     * @param Player $player
     * @return $this
     */
    public function addPlayer(Player $player)
    {
        $count = $this->getTotalPlayers();
        
        // give player a name if they dont have one
        if (empty($player->getName())) {
            $player->setName(self::DEFAULT_PLAYER_NAME_PREFIX . ($count + 1)); // we add 1 since $count is an array pointer
        }
        
        // we set an id to make it easier to generate results later
        $player->setId($count + 1);
        
        $this->players[$count] = $player;
        
        return $this;
    }
    
    /**
     * Add Players
     *
     * @return $this
     * @throws RockPaperScissorsSpockLizardException
     */
    public function addPlayers()
    {
        if (func_num_args() < 1) {
            throw new RockPaperScissorsSpockLizardException('No player objects supplied to addPlayers()');
        }
        
        $count = 0;
        foreach (func_get_args() as $player) {
            
            $count++;
            // error if not Player objects
            if (!$player instanceof Player) {
                throw new RockPaperScissorsSpockLizardException('Parameter # ' . $count . ' is not an instance of Player()');
            }
            
            $this->addPlayer($player);
        }
        
        return $this;
    }

    /**
     * Get Round Winners
     * @return mixed
     */
    public function getRoundWinners()
    {
        $last_round = $this->getOutcomes();
        $outcome = end($last_round);
        return $outcome['winners'];
    }

    /**
     * Get Game Winners
     * @return array
     */
    public function getWinners()
    {
        $outcomes = $this->getOutcomes();

        foreach ($outcomes as $outcome)
        {
            $winners[] = $outcome['winners'];
        }

        return $winners;
    }
    
    /**
     * Get Outcomes
     * @return mixed
     */
    public function getOutcomes()
    {
        return $this->outcomes;
    }
    
    /**
     * @return bool
     */
    public function getPlayers()
    {
        return $this->players;
    }
    
    /**
     * Get Total Player Count
     * @return int
     */
    public function getTotalPlayers()
    {
        $player_count = $this->getPlayers();
    
        return $player_count === false ? 0 : count($player_count);
    }
}

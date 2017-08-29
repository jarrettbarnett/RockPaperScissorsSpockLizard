<?php namespace Jarrett;

use Jarrett\RockPaperScissorsSpockLizardException;

/**
 * Class RockPaperScissorsSpockLizard
 *
 * @author Jarrett Barnett <hello@jarrettbarnett.com
 * @see http://www.samkass.com/theories/RPSSL.html
 */
class RockPaperScissorsSpockLizard {

    const ROCK = 0;
    const PAPER = 1;
    const SCISSORS = 2;
    const SPOCK = 3;
    const LIZARD = 4;

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
    private $outcomes = [
        self::ROCK => [
            self::SCISSORS,
            self::LIZARD
        ],
        self::PAPER => [
            self::ROCK,
            self::SPOCK
        ],
        self::SCISSORS => [
            self::PAPER,
            self::LIZARD
        ],
        self::SPOCK => [
            self::SCISSORS,
            self::ROCK
        ],
        self::LIZARD => [
            self::SPOCK,
            self::PAPER
        ]
    ];

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
     * The last played move
     * @var $last_play
     */
    private $last_play = false;
    
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
     * RockPaperScissorsSpockLizard constructor.
     */
    public function __construct()
    {
        $this->moves_index_end = count(array_keys($this->outcomes)) - 1;
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
        $this->setRounds(0);

        return $this;
    }
    
    /**
     * Play Move
     *
     * @param $move
     *
     * @return bool
     * @throws \Jarrett\RockPaperScissorsSpockLizardException
     */
    public function play($move)
    {
        if (empty($move)) {
            throw new RockPaperScissorsSpockLizardException('Move parameter cannot be empty for play()');
        }
        
        $play_index = $this->getPlayIndex($move);
        if ($play_index == false)
        {
            throw new RockPaperScissorsSpockLizardException('Invalid move!');
        }
    
        if (!isset($outcomes[$play_index])) {
            return false;
        }
        
        $this->last_play = $move;
        
        $this->last_outcome = $this->determineOutcome($play_index);
        
        return $this->last_outcome;
    }
    
    protected function getPlayIndex($move)
    {
        return array_flip($this->labels[$move]);
    }
    
    /**
     * Get Random Move Using Mersenne Twister for even distribution
     * @return int
     */
    private function generateMove()
    {
        return $this->outcomes[mt_rand(0, $this->moves_index_end)];
    }
    
    /**
     * Determine Outcome
     * @param $player_move
     * @param $opponent_move
     * @return string
     */
    public function determineOutcome($player_move, $opponent_move)
    {
        // if no opponent parameter, generate move as computer opponent
        if (empty($second_move))
        {
            $opponent_move = $this->generateMove();
        }
        
        // compare player with opponent
        if (isset($this->outcomes[$player_move][$opponent_move])) {
            return $this->last_outcome = 'player';
        }
        
        // check opponent against player
        if (isset($this->outcomes[$opponent_move][$player_move])) {
            return $this->last_outcome = 'opponent';
        }
        
        return $this->last_outcome = 'tie';
    }
    
}

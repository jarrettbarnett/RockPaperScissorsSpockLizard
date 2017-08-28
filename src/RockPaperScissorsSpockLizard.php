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
     * The last played move
     * @var $last_play
     */
    private $last_play = false;

    /**
     * Set Rounds
     * @param $rounds
     * @return $this
     * @throws \Jarrett\RockPaperScissorsSpockLizardException
     */
    public function setRounds($rounds)
    {
        if (!is_numeric($rounds))
        {
            throw new RockPaperScissorsSpockLizardException('Invalid value supplied for setRounds()');
        }

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
     * @param $move
     * @throws \Jarrett\RockPaperScissorsSpockLizardException
     */
    public function play($move)
    {
        if (empty($move))
        {
            throw new RockPaperScissorsSpockLizardException('Move parameter cannot be empty for play()');
        }

        $this->last_play = $move;
    }
    
    /**
     * __call
     * @param $name
     * @param $arguments
     * @method RockPaperScissorsSpockLizard playRock()
     * @method RockPaperScissorsSpockLizard playPaper()
     * @method RockPaperScissorsSpockLizard playScissors()
     * @method RockPaperScissorsSpockLizard playSpock()
     * @method RockPaperScissorsSpockLizard playLizard()
     * @return null - if not an approved play method
     */
    function __call($name, $arguments)
    {
        if (strpos($name, 'play') !== 0) {
            return null;
        }
        
        $move = substr($name, 4);
        if (in_array($move, array_keys($this->outcomes))) {
            $this->play(strtolower($move));
        }
    }
    
    /**
     * Get Last Play
     * @return mixed
     */
    public function getLastPlay()
    {
        return $this->last_play;
    }
}

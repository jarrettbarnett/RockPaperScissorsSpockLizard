<?php namespace Jarrett;

use Jarrett\RockPaperScissorsSpockLizardException;

/**
 * Class RockPaperScissorsSpockLizard
 * @package Jarrett
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

    private $rounds;

    /**
     * Set Rounds
     * @param $rounds
     * @throws \Jarrett\RockPaperScissorsSpockLizardException
     */
    public function setRounds($rounds)
    {
        if (!is_numeric($rounds))
        {
            throw new RockPaperScissorsSpockLizardException('Invalid number of rounds supplied for setRounds()');
        }

        $this->rounds = (int) $rounds;
    }

    /**
     * Get Rounds
     * @return mixed
     */
    public function getRounds()
    {
        return $this->rounds;
    }
}
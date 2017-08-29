<?php namespace Jarrett\RockPaperScissorsSpockLizard;

use Jarrett\RockPaperScissorsSpockLizardException;

/**
 * Class RockPaperScissorsSpockLizard
 *
 * @author Jarrett Barnett <hello@jarrettbarnett.com
 * @see http://www.samkass.com/theories/RPSSL.html
 */
class Player implements PlayerInterface
{
    /**
     * Player name
     * @var bool|Player
     */
    protected $name;
    
    /**
     * @var $moves
     */
    private $moves = [];

    /**
     * Player constructor.
     * @param string $name
     */
    public function __construct($name = '')
    {
        $this->name = $this->setName($name);
    }
    
    /**
     * Queue a play
     * @param $move
     * @return $this
     * @throws RockPaperScissorsSpockLizardException
     */
    public function play($move)
    {
        $last_move = $this->getLastMove();
        
        if (is_array($last_move) && array_shift($last_move) === false)
        {
            throw new RockPaperScissorsSpockLizardException('Cannot set another move until the previous move has been played');
        }
        
        $this->moves[] = [$move  => false];
        
        return $this;
    }
    
    /**
     * Set player name
     * @param $name
     * @return $this|bool
     */
    public function setName($name)
    {
        if (empty($name))
        {
            return false;
        }
        
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * Get name
     * @return bool|Player
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Get Move History
     * @return array
     */
    public function getMoveHistory()
    {
        return $this->moves;
    }
    
    /**
     * Get Last Move
     * @return mixed
     */
    public function getLastMove()
    {
        return array_pop($this->moves);
    }
}

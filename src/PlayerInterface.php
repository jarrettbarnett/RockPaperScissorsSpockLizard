<?php namespace Jarrett\RockPaperScissorsSpockLizard;

/**
 * Class RockPaperScissorsSpockLizard
 *
 * @author Jarrett Barnett <hello@jarrettbarnett.com
 * @see http://www.samkass.com/theories/RPSSL.html
 */
interface PlayerInterface {

    /**
     * Make a play
     * @param $move
     */
    public function play($move);
}

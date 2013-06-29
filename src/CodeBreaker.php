<?php

class CodeBreaker
{
    const EXACT_MATCH_SIGN = '+';

    const NUMBER_MATCH_SIGN = '-';

    private $secret;

    /**
     * Constructs object
     *
     * @param string $secret
     */
    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * Returns string with one '+' for each exact match and '-' for each number match
     *
     * @param string $guess
     *
     * @return string
     */
    public function guess($guess)
    {
        $allMatches    = $this->countAllMatches($guess);
        $exactMatches  = $this->countExactMatches($guess);
        $numberMatches = $allMatches - $exactMatches;

        return sprintf('%s%s',
            str_repeat(self::EXACT_MATCH_SIGN, $exactMatches),
            str_repeat(self::NUMBER_MATCH_SIGN, $numberMatches)
        );

    }

    /**
     * Counts Exact Matches
     *
     * @param string $guess
     *
     * @return int
     */
    private function countAllMatches($guess)
    {
        $secretChars = str_split($this->secret);
        $guessChars  = str_split($guess);

        return count(array_intersect($secretChars, $guessChars));
    }

    /**
     * Counts Number matches
     *
     * @param string $guess Guess string
     *
     * @return int
     */
    private function countExactMatches($guess)
    {
        $secretChars = str_split($this->secret);
        $guessChars  = str_split($guess);

        return count(array_intersect_assoc($secretChars, $guessChars));
    }
}
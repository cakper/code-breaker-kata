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
        $exactMatches  = $this->countExactMatches($guess);
        $numberMatches = $this->countNumberMatches($guess);

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
    private function countExactMatches($guess)
    {
        $exactMatches = 0;

        list($secretChars, $guessChars) = $this->getSecretAndGuessChars($guess);

        foreach ($secretChars as $key => $secretChar) {
            if ($this->isExactMatch($key, $secretChar, $guessChars)) {
                $exactMatches++;
            }
        }

        return $exactMatches;
    }

    /**
     * Returns if match is an exact match
     *
     * @param $key
     * @param $secretChar
     * @param $guessChars
     *
     * @return bool
     */
    private function isExactMatch($key, $secretChar, $guessChars)
    {
        return $secretChar === $guessChars[$key];
    }

    /**
     * Counts Number matches
     *
     * @param string $guess Guess string
     *
     * @return int
     */
    private function countNumberMatches($guess)
    {
        $numberMatches = 0;

        list($secretChars, $guessChars) = $this->getSecretAndGuessChars($guess);

        foreach ($secretChars as $key => $secretChar) {
            if ($this->isExactMatch($key, $secretChar, $guessChars)) {
                $this->unsetExactMatch($key, $secretChars, $guessChars);
            } elseif ($this->isNumberMatch($key, $secretChars, $guessChars)) {
                $numberMatches++;
                $this->unsetNumberMatch($key, $secretChars, $guessChars);
            }
        }

        return $numberMatches;
    }

    /**
     * Unset exact match in both arrays
     *
     * @param integer $key         Current key
     * @param array   $secretArray Array of secret chars
     * @param array   $guessArray  Array of guess chars
     */
    private function unsetExactMatch($key, array &$secretArray, array &$guessArray)
    {
        unset($secretArray[$key]);
        unset($guessArray[$key]);
    }

    /**
     * Returns if given char exists in secret array
     *
     * @param integer $key         Current key
     * @param array   $secretArray Array of secret chars
     * @param array   $guessArray  Array of guess chars
     *
     * @return bool
     */
    private function isNumberMatch($key, array $secretArray, array $guessArray)
    {
        return (in_array($guessArray[$key], $secretArray) !== false);
    }

    /**
     * Unset given char in Secret and guest array
     *
     * @param integer $key         Current key
     * @param array   $secretArray Array of secret chars
     * @param array   $guessArray  Array of guess chars
     */
    private function unsetNumberMatch($key, array &$secretArray, array &$guessArray)
    {
        unset($secretArray[array_search($guessArray[$key], $secretArray)]);
        unset($guessArray[$key]);
    }

    /**
     * Returns array of Secret and Guess arrays
     *
     * @param string $guess User guess
     *
     * @return array
     */
    private function getSecretAndGuessChars($guess)
    {
        $secretChars = str_split($this->secret);
        $guessChars  = str_split($guess);

        return array($secretChars, $guessChars);
    }
}
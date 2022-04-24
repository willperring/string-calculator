<?php

namespace StringCalculator\Calculations;

class AdditionCalculation
{
    protected string $_characters;

    /**
     * AdditionCalculation constructor
     *
     * This accepts a single string, which will be a series
     * of numbers, seperated by either a pipe or a comma, or
     * with a leading definition at the start of the string
     * to define a custom separator.
     *
     * @param string $characters
     */
    public function __construct( string $characters )
    {
        $this->_characters = $characters;
    }

    /**
     * Add up the numbers in the string
     *
     * @return int
     */
    public function getResult()
    {
        $result = 0;
        $parts  = preg_split( '/[|,]/', $this->_characters );

        // In reality, this is way too simple to do the job effectively,
        // however, given that part of the brief was to 'write the simplest thing
        // that works', and each behaviour definition is being treated almost as a
        // separate release, we'll use this for now to pass the basic tests and move on.
        foreach( $parts as $part ) {
            if( $value = (int) $part ) {
                $result += $value;
            }
        }

        return $result;
    }
}

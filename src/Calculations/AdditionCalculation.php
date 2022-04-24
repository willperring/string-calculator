<?php

namespace StringCalculator\Calculations;

use StringCalculator\Exceptions\NegativeValueException;

class AdditionCalculation
{
    /**
     * Regex for detecting custom separators
     *
     * Given part of the string we're testing for includes slashes, it makes
     * sense to use custom delimiters here. Hashes are a safe option, as we
     * don't need them elsewhere in the pattern. The use of named captures
     * just helps to make things a bit more readable.
     *
     * @var string
     */
    protected static string $_separatorDefinition = '#^//(?<separator>.*)\\\n(?<values>.*)$#';

    /**
     * Default separator options
     *
     * Out of the box, commas and pipes are supported.
     *
     * @var string
     */
    protected string $_splitRegex = '/[|,]/';

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
        if( preg_match( static::$_separatorDefinition, $characters, $definition) ) {
            $this->_splitRegex = "/{$definition['separator']}/";
            $this->_characters = $definition['values'];
        } else {
            $this->_characters = $characters;
        }
    }

    /**
     * Add up the numbers in the string
     *
     * @throws NegativeValueException
     * @return int
     */
    public function getResult(): int
    {
        $result = 0;
        $parts  = preg_split( $this->_splitRegex, $this->_characters );

        $negatives = [];

        foreach( $parts as $part )
        {
            if( $value = (int) $part )
            {
                if( $value < 0 )
                    $negatives[] = $value;

                $result += $value;
            }
        }

        if( count($negatives) ) {
            $notAllowed = implode( ', ', $negatives );
            throw new NegativeValueException( 'Negatives not allowed: ' . $notAllowed );
        }

        return $result;
    }
}

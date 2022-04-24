<?php

namespace StringCalculator\Calculations;

class AdditionCalculation
{

    protected static string $_separatorDefinition = '#^//(?<separator>.*)\\\n(?<values>.*)$#';

    protected string $_characters;
    protected string $_splitRegex = '/[|,]/';

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
     * @return int
     */
    public function getResult()
    {
        $result = 0;
        $parts  = preg_split( $this->_splitRegex, $this->_characters );

        foreach( $parts as $part ) {
            if( $value = (int) $part ) {
                $result += $value;
            }
        }

        return $result;
    }
}

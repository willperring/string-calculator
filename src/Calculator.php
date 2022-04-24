<?php

namespace StringCalculator;

use StringCalculator\Calculations\AdditionCalculation;
use StringCalculator\Exceptions\NegativeValueException;

class Calculator
{
    /**
     * Add up a string of numbers
     *
     * Technically, this is not the method signature asked for in the test
     * brief, although in order to keep with coding standards it's been renamed
     * from 'Add' to 'add' here.
     *
     * @param string $characters
     *
     * @throws NegativeValueException
     * @return int
     */
    public function add( string $characters ): int
    {
        // Why are we abstracting this here? We want to introduce custom
        // separators, which only affect a single call. By encapsulating this,
        // we can make the most of class properties, whilst also
        // eliminating the need to reset any state on the Calculator.
        return ( new AdditionCalculation($characters) )->getResult();
    }
}

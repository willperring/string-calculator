<?php

namespace StringCalculator;

class Calculator
{
    /**
     * Add up a string of numbers
     *
     * @param string $characters
     *
     * @return void
     */
    public function add( string $characters ): int
    {
        $result = 0;
        $parts  = preg_split( '/[|,]/', $characters );

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

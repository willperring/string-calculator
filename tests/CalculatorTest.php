<?php declare(strict_types=1);


use StringCalculator\Calculator;
use StringCalculator\Exceptions\NegativeValueException;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * Assert the class exists and follows the defined structure
     *
     * Verifies behaviour requirement 1a.
     *
     * @return void
     */
    public function testClassSignature(): void
    {
        $this->assertTrue( class_exists(Calculator::class) );
        $this->assertTrue( method_exists(Calculator::class, 'add') );
    }

    /**
     * Test basic level addition results
     *
     * Verifies behaviour requirement 1b.
     *
     * @param string $characters String of characters for addition
     * @param int    $result     Expected result
     *
     * @dataProvider  providerAddsNumbers
     * @return void
     */
    public function testAddsNumbers( string $characters, int $result ): void
    {
        $calculator = new Calculator();

        $this->assertEquals( $result,
            $calculator->add( $characters ),
        );
    }

    public function providerAddsNumbers(): array
    {
        return [
            'Null string'     => [ '',    0 ],
            'Whitespace'      => [ ' ',   0 ],
            'Single value'    => [ '1',   1 ],
            'Multiple values' => [ '1,2', 3 ]
        ];
    }

    /**
     * Test strings with alternative separators
     *
     * Verifies behaviour requirement 2.
     *
     * @param string $characters Character string for addition
     * @param int    $result     Expected result
     *
     * @dataProvider providerAddsNumbersWithPipe
     * @return void
     */
    public function testAddsNumbersWithPipe( string $characters, int $result ): void
    {
        $calculator = new Calculator();

        $this->assertEquals( $result,
            $calculator->add( $characters )
        );
    }

    public function providerAddsNumbersWithPipe(): array
    {
        return [
            'Single pipe delimiter'    => [ '1|2',   3 ],
            'Multiple pipe delimiters' => [ '1|2|3', 6 ],
            'Multiple delimiters'      => [ '1|2,3', 6 ],
            'Incorrect delimiters'     => [ '1,|2',  3 ]
        ];
    }

    /**
     * Tests the ability to define custom delimiters
     *
     * Verifies behaviour requirement 3a and 3b.
     *
     * @param string $characters
     * @param int    $result
     *
     * Even though it's covered by previous tests, a specification
     * of point 3 is that previous scenarios are still supported,
     * so we could ensure that they are still tested like this.
     *
     * @dataProvider providerAddsNumbers
     * @dataProvider providerAddsNumbersWithPipe
     *
     * ...and then we have specific test cases for the delimiter.
     * @dataProvider providerAddsNumbersWithCustomDelimiter
     *
     * @return void
     */
    public function testAddsNumbersWithCustomDelimiter( string $characters, int $result ): void
    {
        $calculator = new Calculator();

        $this->assertEquals( $result,
            $calculator->add( $characters )
        );
    }

    public function providerAddsNumbersWithCustomDelimiter(): array
    {
        return [
            'Single custom delimiter'     => [ '//;\n1;2',   3 ],
            'Multiple custom delimiters'  => [ '//;\n1;2;3', 6 ],
            'Different custom delimiters' => [ '//!\n2!3!4', 9 ]
        ];
    }

    /**
     * Tests that exceptions are thrown for negative values
     *
     * These could easily get misinterpreted given different separator characters,
     * so we need to ensure that this test covers all forms of default separator,
     * as well as custom ones.
     *
     * This test gets marked as 'risky' if 'beStrictAboutTestsThatDoNotTestAnything'
     * is not set to false, as it does not assert anything specifically.
     *
     * Verifies behaviour requirement 4.
     *
     * @param string $characters
     * @param int[]  $reported
     *
     * @dataProvider providerThrowsExceptionOnNegativeNumbers
     * @return void
     */
    public function testThrowsExceptionsOnNegativeNumbers( string $characters, array $reported ): void
    {
        $this->expectNotToPerformAssertions();
        $this->expectException( NegativeValueException::class );

        // We want the exception message to be informative...
        $this->expectExceptionMessage( 'Negatives not allowed' );

        // ... as well as including each of the negative values.
        foreach( $reported as $expectedValue ) {
            $this->expectExceptionMessage( (string) $expectedValue );
        }

        $calculator = new Calculator();
        $result     = $calculator->add( $characters );

        // We should not get here; an exception should be thrown.
        $this->assertEquals( 'Should not be tested', $result );
    }

    public function providerThrowsExceptionOnNegativeNumbers(): array
    {
        return [
            'Single negative, default delimiter'      => [ '1,-3,4',       [-3]    ],
            'Multiple negatives, multiple delimiters' => [ '1,-5|3,-2',    [-5,-2] ],
            'Single negative, custom delimiter'       => [ '//;\n1;-4;3',  [-4]    ],
            'Multiple negatives, custom delimiter'    => [ '//!\n-1!3!-2', [-1,-2] ],
        ];
    }
}

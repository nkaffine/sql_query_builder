<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/ITest.php");

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 12/26/17
     * Time: 1:31 PM
     */
    class TestSimpleValue implements ITest {
        private $expected;
        private $actual;

        /**
         * Test constructor.
         *
         * @param $expected mixed the expected value of the test.
         * @param $actual mixed the actual value of the test.
         */
        private function __construct($expected, $actual) {
            if ($expected === null || $actual === null) {
                throw new InvalidArgumentException("Expected value and Actual value cannot be null.");
            }
            $this->expected = $expected;
            $this->actual = $actual;
        }

        /**
         * Checks if the two value are the same.
         *
         * @return string the result of the test.
         */
        public function runTest() {
            if ($this->expected === $this->actual) {
                return "Passed";
            } else {
                return "Failed expected: " . $this->expected . "<br>Actual: " . $this->actual;
            }
        }

        /**
         * Creates a new test for convenience.
         *
         * @param $expected mixed the expected value.
         * @param $actual mixed the actual value.
         * @return TestSimpleValue
         */
        public static function newTest($expected, $actual) {
            return new TestSimpleValue($expected, $actual);
        }
    }
<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 12/26/17
     * Time: 1:31 PM
     */
    class Testing {
        /**
         * @var ITest[]
         */
        private $tests;

        /**
         * Testing constructor.
         */
        private function __construct() {
            $this->tests = array();
        }

        /**
         * Adds a test to this testing
         *
         * @param $test TestSimpleValue
         * @return $this
         */
        public function addTest($test) {
            array_push($this->tests, $test);
            return $this;
        }

        /**
         * Runs all of tests in this testing instance and returns a string with details of the results of the test.
         *
         * @return string the results of teh tests.
         */
        public function runTests() {
            $results = "";
            for ($i = 0; $i < sizeof($this->tests); $i++) {
                $results .= "Test " . ($i + 1) . ": " . $this->tests[$i]->runTest() . "<br>";
            }
            return $results;
        }

        /**
         * @return Testing
         */
        public static function newTesting() {
            return new Testing();
        }
    }
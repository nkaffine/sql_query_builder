<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 12/26/17
     * Time: 1:42 PM
     */
    interface ITest {
        /**
         * Checks if the two value are the same.
         *
         * @return string the result of the test.
         */
        public function runTest();

        /**
         * Creates a new test for convenience.
         *
         * @param $expected mixed the expected value.
         * @param $actual mixed the actual value.
         * @return ITest the result of the test.
         */
        public static function newTest($expected, $actual);
    }
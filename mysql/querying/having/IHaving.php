<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/5/18
     * Time: 10:28 AM
     */
    interface IHaving {
        /**
         * Generates the string having statement of this where.
         *
         * @return string the having statement.
         */
        public function generateHaving();

        /**
         * Determines if there is a having clause.
         *
         * @return boolean if there is a having clause.
         */
        public function isHaving();
    }
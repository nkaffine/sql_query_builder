<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/5/18
     * Time: 3:23 PM
     */

    /**
     * Interface ITable represents a table in the database.
     */
    interface ITable {
        /**
         * Gets the string for the table that will be used in the query.
         *
         * @return string for the table to be used in the query.
         */
        public function getTable();

        /**
         * Sets the alias of the table for the query.
         *
         * @param $alias string the alias.
         * @return void
         */
        public function setAlias($alias);
    }
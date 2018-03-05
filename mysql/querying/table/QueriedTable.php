<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/5/18
     * Time: 3:30 PM
     */
    class QueriedTable implements ITable {
        private $queriedTable;
        private $alias;

        /**
         * QueriedTable constructor.
         *
         * @param $queriedTable SelectQuery the queried table being used.
         * @param $alias string the alias for the table.
         */
        public function __construct($queriedTable, $alias) {
            if ($queriedTable === null || $alias === null) {
                throw new InvalidArgumentException("The table and the alias must not be null");
            }
            $this->queriedTable = $queriedTable;
            $this->alias = $alias;
        }

        /**
         * Gets the string for the table that will be used in the query.
         *
         * @return string for the table to be used in the query.
         */
        public function getTable() {
            return "(" . $this->queriedTable->generateQuery() . ") " . $this->alias;
        }

        /**
         * Sets the alias of the table for the query.
         *
         * @param $alias string the alias.
         * @return void
         */
        public function setAlias($alias) {
            $this->alias = $alias;
        }
    }
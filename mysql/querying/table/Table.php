<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/5/18
     * Time: 3:25 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/table/ITable.php");

    class Table implements ITable {
        private $table;
        private $alias;

        public function __construct($table) {
            if ($table === null) {
                throw new InvalidArgumentException("Table cannot be null");
            }
            $this->table = $table;
        }

        /**
         * Gets the string for the table that will be used in the query.
         *
         * @return string for the table to be used in the query.
         */
        public function getTable() {
            if ($this->alias === null) {
                return $this->table;
            } else {
                return $this->table . " " . $this->alias;
            }
        }

        /**
         * Sets the alias of the table for the query.
         *
         * @param $alias string the alias.
         * @return void
         */
        public function setAlias($alias) {
            if ($alias === null) {
                throw new InvalidArgumentException("alias cannot be null");
            }
            $this->alias = $alias;
        }
    }
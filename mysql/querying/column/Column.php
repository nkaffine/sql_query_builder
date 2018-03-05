<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/column/IColumn.php");

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/5/18
     * Time: 10:42 AM
     */
    class Column implements IColumn {
        private $column;
        private $alias;

        /**
         * Column constructor.
         *
         * @param $column string the name of the column in the database.
         */
        private function __construct($column) {
            if ($column === null) {
                throw new InvalidArgumentException("Column cannot be null");
            }
            $this->column = $column;
        }

        /**
         * Gets the text version of this column.
         *
         * @return string the text version of this column.
         */
        public function getColumn() {
            if($this->alias !== null) {
                return $this->column . " " . $this->alias;
            } else {
                return $this->column;
            }
        }

        /**
         * Static constructor.
         *
         * @param $column string the name of the column in the database.
         * @return Column representing the column in the database.
         */
        public static function Column($column) {
            return new Column($column);
        }

        /**
         * Sets the column alias of this column.
         *
         * @param $alias string the alias for this column.
         * @return void
         */
        public function setAlias($alias) {
            if ($alias === false) {
                throw new InvalidArgumentException("Alias cannot be null");
            }
            $this->alias = $alias;
        }
    }
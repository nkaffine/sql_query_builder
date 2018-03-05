<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/column/IColumn.php");

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/5/18
     * Time: 10:42 AM
     */
    class AggregateColumn implements IColumn {
        protected $aggregateFunction;
        protected $aggregateColumn;
        protected $distinct;
        protected $alias;

        private function __construct($function, $column, $distinct) {
            if ($function === null || $column === null || $distinct === null) {
                throw new InvalidArgumentException("Function and Column must not be null");
            }
            $this->aggregateFunction = $function;
            $this->aggregateColumn = $column;
            $this->distinct = $distinct;
        }

        /**
         * Gets the text version of this column.
         *
         * @return string the text version of this column.
         */
        public function getColumn() {
            $string = $this->aggregateFunction . "(";
            if ($this->distinct) {
                $string .= "DISTINCT ";
            }
            $string .= $this->aggregateColumn . ")";
            if ($this->alias !== null) {
                $string .= " " . $this->alias;
            }
            return $string;
        }

        /**
         * Creates a column for representing the average of the given column.
         *
         * @param $column string the name of the column being aggregated in the database.
         * @param $distinct boolean whether the average is using the distinct keyword.
         * @return AggregateColumn the column with the aggregate function.
         */
        public static function Average($column, $distinct) {
            return new AggregateColumn("AVG", $column, $distinct);
        }

        /**
         * Creates a column for representing the count of the given column.
         *
         * @param $column string the name of the column being aggregated in the database.
         * @param $distinct boolean whether the count is using the distinct keyword.
         * @return AggregateColumn the column with the aggregate function.
         */
        public static function Count($column, $distinct) {
            return new AggregateColumn("COUNT", $column, $distinct);
        }

        /**
         * Creates a column for representing the GroupConcat of the given column.
         *
         * @param $column string the name of the column being aggregated in the database.
         * @param $distinct boolean whether the GroupConcat is using the distinct keyword.
         * @return AggregateColumn the column with the aggregate function.
         */
        public static function GroupConcat($column, $distinct) {
            return new AggregateColumn("GROUP_CONCAT", $column, $distinct);
        }

        /**
         * Creates a column for representing the max of the given column.
         *
         * @param $column string the name of the column being aggregated in the database.
         * @return AggregateColumn the column with the aggregate function.
         */
        public static function Max($column) {
            return new AggregateColumn("MAX", $column, false);
        }

        /**
         * Creates a column for representing the min of the given column.
         *
         * @param $column string the name of the column being aggregated in the database.
         * @return AggregateColumn the column with the aggregate function.
         */
        public static function Min($column) {
            return new AggregateColumn("MIN", $column, false);
        }

        /**
         * Creates a column for representing the sum of the given column.
         *
         * @param $column string the name of the column being aggregated in the database.
         * @param $distinct boolean whether the min is using the distinct keyword.
         * @return AggregateColumn the column with the aggregate function.
         */
        public static function Sum($column, $distinct) {
            return new AggregateColumn("SUM", $column, $distinct);
        }

        /**
         * Creates a column for representing the population standard deviation of the given column.
         *
         * @param $column string the name of the column being aggregated in the database.
         * @return AggregateColumn the column with the aggregate function.
         */
        public static function PopulationStandardDeviation($column) {
            return new AggregateColumn("STDDEV_POP", $column, false);
        }

        /**
         * Creates a column for representing the population variance of the given column.
         *
         * @param $column string the name of the column being aggregated in the database.
         * @return AggregateColumn the column with the aggregate function.
         */
        public static function PopulationVariance($column) {
            return new AggregateColumn("VAR_POP", $column, false);
        }

        /**
         * Creates a column for representing the sample standard deviation of the given column.
         *
         * @param $column string the name of the column being aggregated in the database.
         * @return AggregateColumn the column with the aggregate function.
         */
        public static function SampleStandardDeviation($column) {
            return new AggregateColumn("STDDEV_SAMP", $column, false);
        }

        /**
         * Creates a column for representing the sample variance of the given column.
         *
         * @param $column string the name of the column being aggregated in the database.
         * @return AggregateColumn the column with the aggregate function.
         */
        public static function SampleVariance($column) {
            return new AggregateColumn("VAR_SAMP", $column, false);
        }

        /**
         * Sets the column alias of this column.
         *
         * @param $alias string the alias for this column.
         * @return void
         */
        public function setAlias($alias) {
            if ($alias === null) {
                throw new InvalidArgumentException("Alias cannot be null");
            }
            $this->alias = $alias;
        }
    }
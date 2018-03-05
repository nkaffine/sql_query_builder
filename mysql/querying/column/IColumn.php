<?php

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/5/18
     * Time: 10:35 AM
     */

    /**
     * Interface IColumn representing a column in a select statement of a query.
     */
    interface IColumn {
        /**
         * Gets the text version of this column.
         *
         * @return string the text version of this column.
         */
        public function getColumn();

        /**
         * Sets the column alias of this column.
         *
         * @param $alias string the alias for this column.
         * @return void
         */
        public function setAlias($alias);
    }
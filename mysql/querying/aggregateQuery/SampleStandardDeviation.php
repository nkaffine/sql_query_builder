<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/aggregateQuery/NonDistinctAggregateQuery.php");

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 12/26/17
     * Time: 1:08 PM
     */
    class SampleStandardDeviation extends NonDistinctAggregateQuery {
        /**
         * Returns the name of the function for this query.
         *
         * @return string the name of the function for this query.
         */
        protected function mathFunction() {
            return "STDDEV_SAMP";
        }
    }
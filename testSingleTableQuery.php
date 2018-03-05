<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/Testing.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/TestSimpleValue.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/select/SelectQuery.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/where/Where.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/DBValue.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/where/OrWhereCombiner.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/where/NotWhere.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/where/Like.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/aggregateQuery/AggregateQuery.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/groupBy/GroupBy.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/select/joinQueries/DBJoinTable.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/select/joinQueries/InnerJoin.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/select/joinQueries/LeftJoin.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/select/joinQueries/QueriedJoinTable.php");

    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 12/26/17
     * Time: 1:58 PM
     */
    $query = new SelectQuery("users", "user_id");
    $query2 = new SelectQuery("users", "user_id", "first", "last");
    // Testing general query forming with just parameters.
    echo "Tests for queries just getting parameters<br>";
    $testing =
        Testing::newTesting()->addTest(TestSimpleValue::newTest("SELECT user_id FROM users", $query->generateQuery()))
            ->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users", $query2->generateQuery()));
    echo $testing->runTests();
    // Testing DB Value
    echo "<br>Testing DBValue class<br>";
    $testing = Testing::newTesting()->addTest(TestSimpleValue::newTest("'hello'",
        DBValue::stringValue("hello")->getValueString()))->addTest(TestSimpleValue::newTest("hello",
        DBValue::nonStringValue("hello")->getValueString()));
    echo $testing->runTests();
    // Testing where statements
    echo "<br>Testing Where Statements<br>";
    $query->where(Where::whereEqualValue("user_id", DBValue::nonStringValue(1)));
    $query2->where(Where::whereIsNotValue("user_id", DBValue::nonStringValue(1)));
    $testing = Testing::newTesting()->addTest(TestSimpleValue::newTest("SELECT user_id FROM users WHERE user_id = 1",
        $query->generateQuery()))
        ->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE user_id != 1",
            $query2->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Where::whereGreaterThanValue("user_id", DBValue::nonStringValue(1)));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE user_id > 1",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Where::whereGreaterOrEqualValue("user_id", DBValue::nonStringValue(1)));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE user_id >= 1",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Where::whereLessThanValue("user_id", DBValue::nonStringValue(3)));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE user_id < 3",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Where::whereLessOrEqualValue("user_id", DBValue::nonStringValue(2)));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE user_id <= 2",
        $query->generateQuery()));
    $query = new SelectQuery("sale_shipments", "sale_id", "shipping_date");
    $query->where(Where::whereIsNull("shipping_date"));
    $testing->addTest(TestSimpleValue::newTest("SELECT sale_id, shipping_date FROM sale_shipments WHERE shipping_date is null",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Where::whereEqualValue("first", DBValue::stringValue("nick")));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE first = 'nick'",
        $query->generateQuery()));
    //Testing not where
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(NotWhere::newWhere(Where::whereLessThanValue("user_id", DBValue::nonStringValue(3))));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE NOT (user_id < 3)",
        $query->generateQuery()));
    echo $testing->runTests();
    //Testing And Combiner
    echo "<br>Testing multiple where clauses<br>";
    $testing = Testing::newTesting();
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(AndWhereCombiner::newCombiner()->addWhere(Where::whereGreaterThanValue("user_id",
        DBValue::nonStringValue(1)))->addWhere(Where::whereLessThanValue("user_id", DBValue::nonStringValue(3)))
        ->addWhere(Where::whereEqualValue("user_id", DBValue::nonStringValue(2))));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE (user_id > 1) AND (user_id < 3) AND (user_id = 2)",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Where::whereGreaterThanValue("user_id", DBValue::nonStringValue(1)));
    $query->where(Where::whereLessThanValue("user_id", DBValue::nonStringValue(3)));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE (user_id > 1) AND (user_id < 3)",
        $query->generateQuery()));
    //Testing Or Combiners
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(OrWhereCombiner::newCombiner()->addWhere(Where::whereEqualValue("user_id",
        DBValue::nonStringValue(3)))->addWhere(Where::whereEqualValue("first", DBValue::stringValue("nick")))
        ->addWhere(Where::whereEqualValue("last", DBValue::stringValue("Briggs"))));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE (user_id = 3) OR (first = 'nick') OR (last = 'Briggs')",
        $query->generateQuery()));
    //Testing ands embedded in an or
    $query = new SelectQuery("users", "user_id", "first", "last");
    $and1 = AndWhereCombiner::newCombiner()->addWhere(Where::whereLessThanValue("user_id", DBValue::nonStringValue(3)))
        ->addWhere(Where::whereGreaterThanValue("user_id", DBValue::nonStringValue(1)));
    $and2 = AndWhereCombiner::newCombiner()->addWhere(Where::whereIsNotValue("first", DBValue::stringValue("bobby")))
        ->addWhere(Where::whereIsNotValue("last", DBValue::stringValue("godin")));
    $query->where(OrWhereCombiner::newCombiner()->addWhere($and1)->addWhere($and2));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE ((user_id < 3) " .
        "AND (user_id > 1)) OR ((first != 'bobby') AND (last != 'godin'))",
        $query->generateQuery()));
    //Testing ors embedded in an and
    $query = new SelectQuery("users", "user_id", "first", "last");
    $or1 = OrWhereCombiner::newCombiner()->addWhere(Where::whereEqualValue("first", DBValue::stringValue("nick")))
        ->addWhere(Where::whereEqualValue("first", DBValue::stringValue("bobby")));
    $or2 = OrWhereCombiner::newCombiner()->addWhere(Where::whereGreaterThanValue("user_id", DBValue::nonStringValue(1)))
        ->addWhere(Where::whereEqualValue("first", DBValue::stringValue("brent")));
    $query->where(AndWhereCombiner::newCombiner()->addWhere($or1)->addWhere($or2));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE " .
        "((first = 'nick') OR (first = 'bobby')) AND ((user_id > 1) OR (first = 'brent'))", $query->generateQuery()));
    //Testing combiners with the not
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(NotWhere::newWhere($and2));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE NOT ((first != 'bobby') AND (last != 'godin'))",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(NotWhere::newWhere(OrWhereCombiner::newCombiner()->addWhere($and1)->addWhere($and2)));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE NOT (((user_id < 3) " .
        "AND (user_id > 1)) OR ((first != 'bobby') AND (last != 'godin')))", $query->generateQuery()));
    //Testing like
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Like::newLike("first")->contains("i"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE first LIKE '%i%'",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Like::newLike("first")->startsWith("n"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE first LIKE 'n%'",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Like::newLike("first")->endsWith("c"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE first LIKE '%c'",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Like::newLike("first")->startsWith("n")->endsWith("k"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE first LIKE 'n%k'",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Like::newLike("first")->contains("o")->endsWith("y"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE first LIKE '%o%y'",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Like::newLike("first")->startsWith("b")->contains("b"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE first LIKE 'b%b%'",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Like::newLike("first")->startsWith("b")->contains("b")->endsWith("y"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE first LIKE 'b%b%y'",
        $query->generateQuery()));
    echo $testing->runTests();
    //Testing order
    echo "<br>test Order<br>";
    $testing = Testing::newTesting();
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->order(OrderStatement::orderDesc("user_id"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users ORDER BY user_id DESC",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->order(OrderStatement::orderAsc("user_id"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users ORDER BY user_id ASC",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->order(OrderStatement::orderNoDirection("user_id"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users ORDER BY user_id",
        $query->generateQuery()));
    //Testing Order Combiner
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->order(OrderCombiner::newCombiner()->addOrder(OrderStatement::orderAsc("first"))
        ->addOrder(OrderStatement::orderDesc("user_id")));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users ORDER BY first ASC, user_id DESC",
        $query->generateQuery()));
    echo $testing->runTests();
    //Testing aggregate queries
    echo "<br>Testing Aggregate Queries<br>";
    $testing = Testing::newTesting();
    $query = new AverageQuery("users", "user_id");
    $testing->addTest(TestSimpleValue::newTest("SELECT AVG(user_id) FROM users", $query->generateQuery()));
    $query = new CountQuery("users", "user_id");
    $testing->addTest(TestSimpleValue::newTest("SELECT COUNT(user_id) FROM users", $query->generateQuery()));
    $query = new GroupConcatQuery("users", "first");
    $testing->addTest(TestSimpleValue::newTest("SELECT GROUP_CONCAT(first) FROM users", $query->generateQuery()));
    $query = new MaxQuery("users", "user_id");
    $testing->addTest(TestSimpleValue::newTest("SELECT MAX(user_id) FROM users", $query->generateQuery()));
    $query = new MinQuery("users", "user_id");
    $testing->addTest(TestSimpleValue::newTest("SELECT MIN(user_id) FROM users", $query->generateQuery()));
    $query = new PopulationStandardDeviation("users", "user_id");
    $testing->addTest(TestSimpleValue::newTest("SELECT STDDEV_POP(user_id) FROM users", $query->generateQuery()));
    $query = new PopulationVariance("users", "user_id");
    $testing->addTest(TestSimpleValue::newTest("SELECT VAR_POP(user_id) FROM users", $query->generateQuery()));
    $query = new SampleStandardDeviation("users", "user_id");
    $testing->addTest(TestSimpleValue::newTest("SELECT STDDEV_SAMP(user_id) FROM users", $query->generateQuery()));
    $query = new SampleVariance("users", "user_id");
    $testing->addTest(TestSimpleValue::newTest("SELECT VAR_SAMP(user_id) FROM users", $query->generateQuery()));
    $query = new SumQuery("users", "user_id");
    $testing->addTest(TestSimpleValue::newTest("SELECT SUM(user_id) FROM users", $query->generateQuery()));
    echo $testing->runTests();
    //Testing group by statements
    echo "<br>Testing Group By Statment</br>";
    $testing = Testing::newTesting();
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->groupBy(GroupBy::groupBy()->addParameter("first"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users GROUP BY first",
        $query->generateQuery()));
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->groupBy(GroupBy::groupBy()->addParameter("first")->addParameter("last"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users GROUP BY first, last",
        $query->generateQuery()));
    echo $testing->runTests();
    //Testing limit statements
    echo "<br>Testing Limit Statements<br>";
    $testing = Testing::newTesting();
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->limit(1);
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users LIMIT 1",
        $query->generateQuery()));
    $query->limit(2);
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users LIMIT 2",
        $query->generateQuery()));
    echo $testing->runTests();
    //Testing order, limit, where, and group by all in one query
    echo "<br>Testing Order, Limit, Where, Group By in one query<br>";
    $testing = Testing::newTesting();
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->limit(2);
    $query->where(Where::whereIsNotValue("user_id", DBValue::nonStringValue(2)));
    $query->order(OrderStatement::orderDesc("user_id"));
    $query->groupBy(GroupBy::groupBy()->addParameter("first")->addParameter("last"));
    $testing->addTest(TestSimpleValue::newTest("SELECT user_id, first, last FROM users WHERE user_id != 2" .
        " GROUP BY first, last ORDER BY user_id DESC LIMIT 2", $query->generateQuery()));
    echo $testing->runTests();
    //Testing aggregate query with group by
    echo "<br>Testing Aggregate Functions with where, order by, group by, and limit<br>";
    $testing = Testing::newTesting();
    $query = new MaxQuery("users", "user_id");
    $query->groupBy(GroupBy::groupBy()->addParameter("first"));
    $testing->addTest(TestSimpleValue::newTest("SELECT MAX(user_id) FROM users GROUP BY first",
        $query->generateQuery()));
    $query = new MaxQuery("users", "user_id");
    $query->groupBy(GroupBy::groupBy()->addParameter("first"));
    $query->limit(1);
    $testing->addTest(TestSimpleValue::newTest("SELECT MAX(user_id) FROM users GROUP BY first LIMIT 1",
        $query->generateQuery()));
    $query = new MaxQuery("users", "user_id");
    $query->where(Where::whereIsNotValue("first", DBValue::stringValue("bobby")));
    $testing->addTest(TestSimpleValue::newTest("SELECT MAX(user_id) FROM users WHERE first != 'bobby'",
        $query->generateQuery()));
    $query = new MaxQuery("users", "user_id");
    $query->groupBy(GroupBy::groupBy()->addParameter("first"));
    $query->order(OrderStatement::orderDesc("user_id"));
    $testing->addTest(TestSimpleValue::newTest("SELECT MAX(user_id) FROM users GROUP BY first ORDER BY user_id DESC",
        $query->generateQuery()));
    $query = new MaxQuery("users", "user_id");
    $query->groupBy(GroupBy::groupBy()->addParameter("first"));
    $query->order(OrderStatement::orderDesc("user_id"));
    $query->where(Where::whereLessThanValue("user_id", DBValue::nonStringValue(6)));
    $query->limit(3);
    $testing->addTest(TestSimpleValue::newTest("SELECT MAX(user_id) FROM users WHERE user_id < 6 GROUP BY " .
        "first ORDER BY user_id DESC LIMIT 3", $query->generateQuery()));
    echo $testing->runTests();
    //Testing joining queries
    echo "<br>Testing Joining Queries<br>";
    $testing = Testing::newTesting();
    $table1 = new DBJoinTable("users", "user_id");
    $table1->addParams("user_id", "first", "last");
    $table2 = new DBJoinTable("user_info", "user_id");
    $table2->addParams("email");
    $query = new InnerJoin($table1, $table2);
    $testing->addTest(TestSimpleValue::newTest("SELECT users.user_id, users.first, users.last, " .
        "user_info.email FROM users INNER JOIN user_info USING (user_id)", $query->generateQuery()));
    $table3 = new DBJoinTable("user_age", "user_id");
    $table3->addParams("age");
    $query = new InnerJoin($table1, $table2, $table3);
    $testing->addTest(TestSimpleValue::newTest("SELECT users.user_id, users.first, users.last, " .
        "user_info.email, user_age.age FROM users INNER JOIN user_info USING (user_id) INNER JOIN " .
        "user_age USING (user_id)", $query->generateQuery()));
    $query = new LeftJoin($table1, $table2);
    $testing->addTest(TestSimpleValue::newTest("SELECT users.user_id, users.first, users.last, " .
        "user_info.email FROM users LEFT JOIN user_info USING (user_id)", $query->generateQuery()));
    $query = new LeftJoin($table1, $table2, $table3);
    $testing->addTest(TestSimpleValue::newTest("SELECT users.user_id, users.first, users.last, " .
        "user_info.email, user_age.age FROM users LEFT JOIN user_info USING (user_id) LEFT JOIN " .
        "user_age USING (user_id)", $query->generateQuery()));
    //Testing joining queries with inner queries
    $query = new SelectQuery("users", "user_id", "first", "last");
    $query->where(Where::whereGreaterThanValue("user_id", DBValue::nonStringValue(3)));
    $table4 = new QueriedJoinTable($query, "results");
    $table4->addParams("user_id", "first", "last");
    $query = new InnerJoin($table4, $table2);
    $testing->addTest(TestSimpleValue::newTest("SELECT results.user_id, results.first, results.last, user_info.email FROM " .
        "(SELECT user_id, first, last FROM users WHERE user_id > 3) AS results INNER JOIN user_info USING (user_id)",
        $query->generateQuery()));
    $query->where(Where::whereEqualValue("user_id", DBValue::nonStringValue(4)));
    $testing->addTest(TestSimpleValue::newTest("SELECT results.user_id, results.first, results.last, user_info.email FROM " .
        "(SELECT user_id, first, last FROM users WHERE user_id > 3) AS results INNER JOIN user_info USING (user_id) WHERE " .
        "user_id = 4", $query->generateQuery()));
    $query = new InnerJoin($table1, $table2);
    $query->order(OrderStatement::orderDesc("user_id"));
    $testing->addTest(TestSimpleValue::newTest("SELECT users.user_id, users.first, users.last, user_info.email FROM " .
        "users INNER JOIN user_info USING (user_id) ORDER BY user_id DESC", $query->generateQuery()));
    $query = new InnerJoin($table1, $table2);
    $query->groupBy(GroupBy::groupBy()->addParameter("first"));
    $testing->addTest(TestSimpleValue::newTest("SELECT users.user_id, users.first, users.last, user_info.email FROM " .
        "users INNER JOIN user_info USING (user_id) GROUP BY first", $query->generateQuery()));
    echo $testing->runTests();





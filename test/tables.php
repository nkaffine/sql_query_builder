<?php
    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/5/18
     * Time: 3:47 PM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/table/Table.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/table/QueriedTable.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/test/Testing.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/test/TestSimpleValue.php");
    $testing = Testing::newTesting();
    //Testing simple tables
    $table1 = new Table("users");
    $table2 = new Table("customers");
    $table3 = new Table("shirts");
    $testing->addTest(TestSimpleValue::newTest("users", $table1->getTable()));
    $testing->addTest(TestSimpleValue::newTest("customers", $table2->getTable()));
    $testing->addTest(TestSimpleValue::newTest("shirts", $table3->getTable()));
    $table1->setAlias("u");
    $table2->setAlias("c");
    $table3->setAlias("s");
    $testing->addTest(TestSimpleValue::newTest("users u", $table1->getTable()));
    $testing->addTest(TestSimpleValue::newTest("customers c", $table2->getTable()));
    $testing->addTest(TestSimpleValue::newTest("shirts s", $table3->getTable()));
    echo $testing->runTests();


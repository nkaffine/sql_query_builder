<?php
    /**
     * Created by PhpStorm.
     * User: Nick
     * Date: 3/5/18
     * Time: 11:58 AM
     */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/column/AggregateColumn.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/mysql/querying/column/Column.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/test/Testing.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/test/TestSimpleValue.php");
    $testing = Testing::newTesting();
    //Testing basic column;
    $column1 = Column::Column("user_id");
    $column2 = Column::Column("fname");
    $column3 = Column::Column("lname");
    $testing->addTest(TestSimpleValue::newTest("user_id", $column1->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("fname", $column2->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("lname", $column3->getColumn()));
    //Testing aggregate columns
    $avg = AggregateColumn::Average("age", false);
    $distinctAvg = AggregateColumn::Average("age", true);
    $testing->addTest(TestSimpleValue::newTest("AVG(age)", $avg->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("AVG(DISTINCT age)", $distinctAvg->getColumn()));
    $count = AggregateColumn::Count("age", false);
    $distinctCount = AggregateColumn::Count("age", true);
    $testing->addTest(TestSimpleValue::newTest("COUNT(age)", $count->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("COUNT(DISTINCT age)", $distinctCount->getColumn()));

    $max = AggregateColumn::Max("age");
    $testing->addTest(TestSimpleValue::newTest("MAX(age)", $max->getColumn()));
    $min = AggregateColumn::Min("age");
    $testing->addTest(TestSimpleValue::newTest("MIN(age)", $min->getColumn()));
    $groupConcat = AggregateColumn::GroupConcat("fname", false);
    $destinctGroupConcat = AggregateColumn::GroupConcat("fname", true);
    $testing->addTest(TestSimpleValue::newTest("GROUP_CONCAT(fname)", $groupConcat->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("GROUP_CONCAT(DISTINCT fname)", $destinctGroupConcat->getColumn()));
    $sum = AggregateColumn::Sum("age", false);
    $distinctSum = AggregateColumn::Sum("age", true);
    $testing->addTest(TestSimpleValue::newTest("SUM(age)", $sum->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("SUM(DISTINCT age)", $distinctSum->getColumn()));
    $popVariance = AggregateColumn::PopulationVariance("age");
    $testing->addTest(TestSimpleValue::newTest("VAR_POP(age)", $popVariance->getColumn()));
    $popStDev = AggregateColumn::PopulationStandardDeviation("age");
    $testing->addTest(TestSimpleValue::newTest("STDDEV_POP(age)", $popStDev->getColumn()));
    $sampleVar = AggregateColumn::SampleVariance("age");
    $testing->addTest(TestSimpleValue::newTest("VAR_SAMP(age)", $sampleVar->getColumn()));
    $sampleStDev = AggregateColumn::SampleStandardDeviation("age");
    $testing->addTest(TestSimpleValue::newTest("STDDEV_SAMP(age)", $sampleStDev->getColumn()));
    //Testing aliasing
    $column1->setAlias("uid");
    $column2->setAlias("first");
    $column3->setAlias("last");
    $testing->addTest(TestSimpleValue::newTest("user_id uid", $column1->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("fname first", $column2->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("lname last", $column3->getColumn()));
    //Testing aggregate columns
    $avg->setAlias("avgage");
    $distinctAvg->setAlias("avgage");
    $testing->addTest(TestSimpleValue::newTest("AVG(age) avgage", $avg->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("AVG(DISTINCT age) avgage", $distinctAvg->getColumn()));
    $count->setAlias("count_age");
    $distinctCount->setAlias("count_age");
    $testing->addTest(TestSimpleValue::newTest("COUNT(age) count_age", $count->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("COUNT(DISTINCT age) count_age", $distinctCount->getColumn()));
    $max->setAlias("maxage");
    $testing->addTest(TestSimpleValue::newTest("MAX(age) maxage", $max->getColumn()));
    $min->setAlias("minage");
    $testing->addTest(TestSimpleValue::newTest("MIN(age) minage", $min->getColumn()));
    $groupConcat->setAlias("group_firsts");
    $destinctGroupConcat->setAlias("group_firsts");
    $testing->addTest(TestSimpleValue::newTest("GROUP_CONCAT(fname) group_firsts", $groupConcat->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("GROUP_CONCAT(DISTINCT fname) group_firsts", $destinctGroupConcat->getColumn()));
    $sum->setAlias("sum_age");
    $distinctSum->setAlias("sum_age");
    $testing->addTest(TestSimpleValue::newTest("SUM(age) sum_age", $sum->getColumn()));
    $testing->addTest(TestSimpleValue::newTest("SUM(DISTINCT age) sum_age", $distinctSum->getColumn()));
    $popVariance->setAlias("age_pop_variance");
    $testing->addTest(TestSimpleValue::newTest("VAR_POP(age) age_pop_variance", $popVariance->getColumn()));
    $popStDev->setAlias("age_pop_stddev");
    $testing->addTest(TestSimpleValue::newTest("STDDEV_POP(age) age_pop_stddev", $popStDev->getColumn()));
    $sampleVar->setAlias("age_samp_var");
    $testing->addTest(TestSimpleValue::newTest("VAR_SAMP(age) age_samp_var", $sampleVar->getColumn()));
    $sampleStDev->setAlias("age_samp_stddev");
    $testing->addTest(TestSimpleValue::newTest("STDDEV_SAMP(age) age_samp_stddev", $sampleStDev->getColumn()));
    echo $testing->runTests();


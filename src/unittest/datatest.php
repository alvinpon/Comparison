<?php

require '../../vendor/autoload.php';

class DataTest extends PHPUnit_Framework_TestCase {
    /**
     * @dataProvider provideURLsForTestCompareURLsOfBoolean
     */
    public function testCompareURLsOfBoolean($firstURL, $secondURL) {
        $objectOfComparingURLs = new \src\ComparingURLs();
        $this->assertTrue($objectOfComparingURLs->compareURLs($firstURL, $secondURL));
        unset($objectOfComparingURLs);
    }

    public function provideURLsForTestCompareURLsOfBoolean() {
        return array(
            // 1. Two identical and valid URLs of owner, result should be true.
            array("http://localhost:4567/unittest/testfile/googleus.html", "http://localhost:4567/unittest/testfile/googleus.html"),

            // 2. different and valid URLs of owner, result should be true or false if contents of URLs are the same or different.
            array("http://localhost:4567/unittest/testfile/googleus.html", "http://localhost:4567/unittest/testfile/googleuk.html")
            );
    }

    /**
     * @dataProvider provideURLsForTestCompareURLsOfString
     */
    public function testCompareURLsOfString($firstURL, $secondURL) {
        $objectOfComparingURLs = new \src\ComparingURLs();
        $this->assertEquals("Invalid URL", $objectOfComparingURLs->compareURLs($firstURL, $secondURL));
        unset($objectOfComparingURLs);
    }

    public function provideURLsForTestCompareURLsOfString() {
        return array(
            // 1. one vaild URL of owner and another invalid URL, result should be true.
            array("http://localhost:4567/unittest/testfile/googleus.html", "Not URL"),
            array("Not URL", "http://localhost:4567/unittest/testfile/googleus.html"),

            // 2. Two invalid URLs, result should be true.
            array("Not URL", "Not URL")
            );
    }

    /**
     * @dataProvider provideURLsForTestGetContentOfURL
     */
    public function testGetContentOfURL($URL, $contentOfURL) {
        $objectOfComparingURLs = new \src\ComparingURLs();
        $this->assertTrue($objectOfComparingURLs->getContentOfURL($URL, $contentOfURL));
        unset($objectOfComparingURLs);
    }

    public function provideURLsForTestGetContentOfURL() {
        return array(
            // 1. one valid URL and string variable, result should be true.
            array("http://localhost:4567/unittest/testfile/googleus.html", ""),

            // 2. one valid URL and not string variable, result should be false.
            array("http://localhost:4567/unittest/testfile/googleus.html", 123),

            // 3. one invalid URL and string variable, result should be false.
            array("Not URL", ""), 

            // 4. one invalid URL and not string variable, result should be false.
            array("Not URL", 123) 
            );
    }

    /**
     * @dataProvider provideFilePathForTestSetListOfURLsFromCSV
     */
    public function testSetListOfURLsFromCSV($filePathOfCSV) {
        $objectOfComparingURLs = new \src\ComparingURLs();
        $this->assertTrue($objectOfComparingURLs->setListOfURLsFromCSV($filePathOfCSV));
        unset($objectOfComparingURLs);
    }

    public function provideFilePathForTestSetListOfURLsFromCSV() {
        return array(
            // 1. one existing file path of CSV, result should be true.
            array("testfile/accounts-smcweb-new.csv"),

            // 2. one not existing file path of CSV, result should be false.
            array("testfile/accounts-smcweb-new-notexisting.csv"),

            // 3. one not file path of CSV, result should be false.
            array("testfile/accounts-smcweb-new.whatever"),

            // 4.  one not string variable, result should be false.
            array(123)
            );
    }

    /**
     * @dataProvider provideFilePathForTestSetListOfURLsFromHTML
     */
    public function testSetListOfURLsFromHTML($filePathOfHTML) {
        $objectOfComparingURLs = new \src\ComparingURLs();
        $this->assertTrue($objectOfComparingURLs->setListOfURLsFromHTML($filePathOfHTML));
        unset($objectOfComparingURLs);
    }

    public function provideFilePathForTestSetListOfURLsFromHTML() {
        return array(
            // 1. one existing file path of HTML, result should be true.
            array("testfile/accounts-smcweb-new.html"),

            // 2. one not existing file path of HTML, result should be false.
            array("testfile/accounts-smcweb-new-notexisting.html"),

            // 3. one not file path of HTML, result should be false.
            array("testfile/accounts-smcweb-new.whatever"),

            // 4.  one not string variable, result should be false.
            array(123)
            );
    }

    /**
     * @dataProvider provideURLsForTestSetTwoURLs
     */
    public function testSetTwoURLs($firstURL, $secondURL) {
        $objectOfComparingURLs = new \src\ComparingURLs();
        $this->assertTrue($objectOfComparingURLs->setTwoURLs($firstURL, $secondURL));
        unset($objectOfComparingURLs);
    }

    public function provideURLsForTestSetTwoURLs() {
        return array(
            // 1. Two valid URLs, result should be true.
            array("http://localhost:4567/unittest/testfile/googleus.html", "http://localhost:4567/unittest/testfile/googleuk.html"),

            // 2. one vaild URL and another invalid URL, result should be false.
            array("http://localhost:4567/unittest/testfile/googleus.html", "Not URL"),
            array("Not URL", "http://localhost:4567/unittest/testfile/googleus.html"),

            // 3. Two invalid URLs, result should be false.
            array("Not URL", "Not URL")
            );
    }
}
?>
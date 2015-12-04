<?php

require '../vendor/autoload.php';

class DataTest extends PHPUnit_Framework_TestCase {
    /**
     * @dataProvider provideURLsForTestCompareURLs
     */
    public function testCompareURLs($firstURL, $secondURL) {
        $objectOfComparingURLs = new \src\ComparingURLs();
        $result = $objectOfComparingURLs->compareURLs($firstURL, $secondURL);
        if (is_bool($result) === true) {
            $this->assertTrue($result);
        } else {
            $this->assertEquals("Invalid URL", $result);
        }
        unset($objectOfComparingURLs);
    }

    public function provideURLsForTestCompareURLs() {
        return array(
            // 1. Two identical and valid URLs of owner, result should be true.
            array("http://accounts.smccd.edu/adesn", "http://accounts.smccd.edu/adesn"),

            // 2. different and valid URLs of owner, result should be true or false if contents of URLs are the same or different.
            array("http://accounts.smccd.edu/adesn", "http://smccd.edu/accounts/adesn"),
            array("http://smccd.edu/accounts/adesn", "http://accounts.smccd.edu/adesn"),

            // 3. one vaild URL of owner and another invalid ULR, result should be true.
            array("http://accounts.smccd.edu/adesn", "Not URL"),
            array("Not URL", "http://accounts.smccd.edu/adesn"),

            // 4. Two invalid URLs, result should be true.
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
            array("http://accounts.smccd.edu/adesn", ""),

            // 2. one valid URL and not string variable, result should be false.
            array("http://accounts.smccd.edu/adesn", 123),

            // 3. one invalid URL and string variable, result should be false.
            array("Not URL", ""), 

            // 4. one invalid URL and not string variable, result should be false.
            array("Not URL", 123) 
            );
    }

    /**
     * @dataProvider provideURLsForTestCompareTwoURLs
     */
    public function testCompareTwoURLs($firstURL, $secondURL) {
        $objectOfComparingURLs = new \src\ComparingURLs();
        $this->assertTrue($objectOfComparingURLs->compareTwoURLs($firstURL, $secondURL));
        unset($objectOfComparingURLs);
    }

    public function provideURLsForTestCompareTwoURLs() {
        return array(
            // 1. Two identical and valid URLs of owner, result should be true.
            array("http://accounts.smccd.edu/adesn", "http://accounts.smccd.edu/adesn"),

            // 2. different and valid URLs of owner, result should be true or false if contents of URLs are the same or different.
            array("http://accounts.smccd.edu/adesn", "http://smccd.edu/accounts/adesn"),
            array("http://smccd.edu/accounts/adesn", "http://accounts.smccd.edu/adesn"),

            // 3. one vaild URL of owner and another invalid ULR, result should be false.
            array("http://accounts.smccd.edu/adesn", "Not URL"),
            array("Not URL", "http://accounts.smccd.edu/adesn"),

            // 4. Two invalid URLs, result should be false.
            array("Not URL", "Not URL")
            );
    }

    /**
     * @dataProvider provideFilePathOfCSVForTestCompareListOfURLsFromCSV
     */
    public function testCompareListOfURLsFromCSV($filePathOfCSV) {
        $objectOfComparingURLs = new \src\ComparingURLs();
        $this->assertTrue($objectOfComparingURLs->compareListOfURLsFromCSV($filePathOfCSV));
        unset($objectOfComparingURLs);
    }

    public function provideFilePathOfCSVForTestCompareListOfURLsFromCSV() {
        return array(
            // 1. one existing file path of CSV, result should be true.
            array("../uploads/accounts-smcweb-new.csv"),

            // 2. one not existing file path of CSV, result should be false.
            array("../uploads/accounts-smcweb-new-notexisting.csv"),

            // 3. one not file path of CSV, result should be false.
            array("../uploads/accounts-smcweb-new.whatever"),

            // 4.  one not string variable, result should be false.
            array(123)
            );
    }

    /**
     * @dataProvider provideFilePathOfHTMLForTestCompareListOfURLsFromHTML
     */
    public function testCompareListOfURLsFromHTML($filePathOfHTML) {
        $objectOfComparingURLs = new \src\ComparingURLs();
        $this->assertTrue($objectOfComparingURLs->compareListOfURLsFromHTML($filePathOfHTML));
        unset($objectOfComparingURLs);
    }

    public function provideFilePathOfHTMLForTestCompareListOfURLsFromHTML() {
        return array(
            // 1. one existing file path of HTML, result should be true.
            array("../uploads/accounts-smcweb-new.html"),

            // 2. one not existing file path of HTML, result should be false.
            array("../uploads/accounts-smcweb-new-notexisting.html"),

            // 3. one not file path of HTML, result should be false.
            array("./uploads/accounts-smcweb-new.whatever"),

            // 4.  one not string variable, result should be false.
            array(123)
            );
    }
}
?>
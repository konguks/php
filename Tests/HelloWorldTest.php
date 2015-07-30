<?php

require_once 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

class HelloWorldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PDO
     */
    private $pdo;

    public function setUp()
    {
        $this->pdo = new PDO($GLOBALS['db_dsn'], $GLOBALS['db_username'], $GLOBALS['db_password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->query("CREATE TABLE hello (what VARCHAR(50) NOT NULL)");
    }

    public function tearDown()
    {
        $this->pdo->query("DROP TABLE hello");
    }

    public function testHelloWorld()
    {
        $helloWorld = new HelloWorld($this->pdo);

        $this->assertEquals('Hello World', $helloWorld->hello());
    }

    public function testHello()
    {
        $helloWorld = new HelloWorld($this->pdo);

        $this->assertEquals('Hello Bar', $helloWorld->hello('Bar'));
    }

    public function testWhat()
    {
        $helloWorld = new HelloWorld($this->pdo);

        $this->assertFalse($helloWorld->what());

        $helloWorld->hello('Bar');

        $this->assertEquals('Bar', $helloWorld->what());
    }

    public function testtweet(){

        $toa = new TwitterOAuth("zrSHDcHAS8mm6RofzbG1qemZI", "tsKT2Y3XYnCzf0SEhb7wANyDXrJVsDnmZtgSRWXcmJTUdGk91b", "9fXtejidHn8AzlggLet8AFkDjjJ1mVoYuYDUa9WQ", "LEcNKVMsJkgKs2z7WenI7mAKPrsFqIEpX4yEQBBXJbnmK");

        $query = array(
            "q" => "#IamFan",
            "count" => 100
        );

        $results = $toa->get('search/tweets', $query);

        $arr = json_decode((string)$results,true);

        $this->assertNotEquals(NULL,$arr[0]->id_str);

    }
}


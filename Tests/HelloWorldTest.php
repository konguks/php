<?php

require_once getcwd().'/twitteroauth/autoload.php';
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
        define('CONSUMER_KEY', 'zrSHDcHAS8mm6RofzbG1qemZI');
        define('CONSUMER_SECRET.', 'tsKT2Y3XYnCzf0SEhb7wANyDXrJVsDnmZtgSRWXcmJTUdGk91b');
        define('ACCESS_TOKEN', '714419437-9fXtejidHn8AzlggLet8AFkDjjJ1mVoYuYDUa9WQ');
        define('ACCESS_TOKEN_SECRET', 'LEcNKVMsJkgKs2z7WenI7mAKPrsFqIEpX4yEQBBXJbnmK');

        $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);

        $query = array(
            "q" => "#IamFan",
            "count" => 100
        );

        $results = $toa->get('search/tweets', $query);

        $this->assertNotEquals(NULL,$results);

    }
}


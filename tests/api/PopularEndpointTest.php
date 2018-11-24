<?php 
use PHPUnit\Framework\TestCase;
class PopularEndpointTest extends TestCase
{
    // use self:: syntax for static variables
    private $curl;
    private $body;
    private $url;
    private $statusCode;
    private $expectedOutcome;
  
    /*
    * @before
    */
    public function setUp() {
        $this->body = "";
        $this->url = "";
        $this->expectedOutcome = 0;
        $this->statusCode = 0;
        $this->curl = curl_init();
        echo "I set up many times\n";
    }

    public function testPopularApiBody(){
        $this->url  = "http://localhost:8080/api/meals/popular";
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_URL, $this->url );
        $this->body = curl_exec($this->curl);
        curl_close($this->curl);  
        $this->assertInternalType('array', json_decode($this->body));
    }
    

    
    public function testPopularApiStatus(){
        $this->url  = "http://localhost:8080/api/meals/popular";
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HEADER  , true); 
        curl_setopt($this->curl, CURLOPT_NOBODY  , true);  
        curl_setopt($this->curl, CURLOPT_URL, $this->url);
        $this->body = curl_exec($this->curl);
        $this->statusCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        curl_close($this->curl);  
        $this->expectedOutcome = 200;
        $this->assertEquals($statusCode,  $expectedOutcome);
    }

    /*
    * @after
    */
    public function tearDown() {
        $this->body = "";
        $this->url = "";
        $this->curl = null;
        echo "I teardown many times\n";
    }
}
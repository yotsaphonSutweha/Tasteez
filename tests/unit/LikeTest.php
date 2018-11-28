<?php 
use PHPUnit\Framework\TestCase;
class LikeTest extends TestCase
{
    private $testUser;
    private $meal;
    private $like;
    private $id;
    private $user;
    private static $conn;
   
    /*
    * @beforeClass
    */
    public static function setUpBeforeClass() {
        $DB_HOST="db4free.net";
        $DB_USER="nciscript_test";
        $DB_PASS="letmein123";
        $DB_NAME="recipes_test";
        try {
            self::$conn = new PDO("mysql:host=".$DB_HOST.";"."dbname=".$DB_NAME.";charset=UTF8",$DB_USER,$DB_PASS);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            echo "Set up: Connected successfully\n"; 
        } catch(PDOException $e) {
            echo "Set up: Connection failed: " . $e->getMessage() . "\n";
        } 
        echo "Set up for User Account endpoints\n";
    }

    /*
    * @before
    */
    public function setUp() {
        $this->user = new Tasteez\Models\User(self::$conn);
        $previousUser = $this->user->findByName("test", "test");
        $previousUserID = (int) $previousUser["id"];
        if($previousUser != null) {
            $this->user->deleteUser($previousUserID);
            echo "Set up: user Deleted\n";
        }
        $this->user->createNew("test", "test", "test");
        echo "Set up: user Created\n";
        $this->testUser = $this->user->findByName("test", "test");
        $this->id = (int) $this->testUser["id"];
        $this->meal = new Tasteez\Models\Meal(self::$conn); 
        $this->like = new Tasteez\Models\Liked(self::$conn);
    }

    // Test like
    public function testUserLikingTheRecipe() {
       $beforeLike = $this->like->getMealLikeValue($this->id, 52820);
       echo "Before like: " . $beforeLike . "\n";
       $this->meal->likeMeal(52820, $this->id);
       $actualOutcome = $this->like->getMealLikeValue($this->id, 52820);
       echo "After like: " . $actualOutcome . "\n";
       $expectedOutcome = 1;
       $this->assertEquals($actualOutcome, $expectedOutcome);
    }

    // Test dislike 
    public function testUserDisLikingTheRecipe() {
        $beforeDisLike = $this->like->getMealLikeValue($this->id, 52809);
        echo "Before dislike: " . $beforeDisLike . "\n";
        $this->meal->dislikeMeal(52809, $this->id);
        $actualOutcome = $this->like->getMealLikeValue($this->id, 52809);
        echo "After dislike: " . $actualOutcome . "\n";
        $expectedOutcome = -1;
        $this->assertEquals($actualOutcome, $expectedOutcome);
    }

    // Test liking the user's liked recipe
    public function testUserLikingTheLikedRecipe() {
        $this->meal->likeMeal(52820, $this->id);
        $beforeMainLike = $this->like->getMealLikeValue($this->id, 52820);
        echo "Before main like: " . $beforeMainLike . "\n";
        $this->meal->likeMeal(52820, $this->id);
        $actualOutcome = $this->like->getMealLikeValue($this->id, 52820);
        echo "After like: " . $actualOutcome . "\n";
        $expectedOutcome = 0;
        $this->assertEquals($actualOutcome, $expectedOutcome);
    }

    // Test disliking the user's disliked recipe
    public function testUserDisLikingTheDislikedRecipe() {
        $this->meal->dislikeMeal(52809, $this->id);
        $beforeMainDisLike = $this->like->getMealLikeValue($this->id, 52809);
        echo "Before main dislike: " . $beforeMainDisLike . "\n";
        $this->meal->dislikeMeal(52809, $this->id);
        $actualOutcome = $this->like->getMealLikeValue($this->id, 52809);
        echo "After dislike: " . $actualOutcome . "\n";
        $expectedOutcome = 0;
        $this->assertEquals($actualOutcome, $expectedOutcome);
    }

    /*
    * @after
    */
    public function tearDown() {
        $this->like->removeLike($this->id, 52820);
        $this->like->removeLike($this->id, 52809);
        echo "Tear down: like/dislike deleted\n";
        $user = new Tasteez\Models\User(self::$conn);
        $user->deleteUser($this->id);
        echo "Tear down: user deleted\n";
    }

    /*
    * @afterClass
    */
    public static function tearDownAfterClass() {
        self::$conn = null;
        echo "Teardown for Like & Dislike endpoints\n";
    }
}
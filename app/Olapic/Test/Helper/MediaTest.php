<?php
namespace Olapic\Test\Helper;

use Silex\WebTestCase;
use Olapic\Controller\MediaControllerProvider;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

/**
 * This class helps to generalize common functions in tests.
 *
 * @package \Olapic\Test\Helper
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 *        
 */
class MediaTest extends WebTestCase
{

    /**
     * An Application instance.
     *
     * @var Application $s_app
     */
    protected static $s_app;

    /**
     * Access token to Instagram.
     *
     * @var string $s_instagram_access_token
     */
    protected static $s_instagram_access_token;

    /**
     * Access token to Facebook.
     *
     * @var string $s_facebook_access_token
     */
    protected static $s_facebook_access_token;

    /**
     * Access token to Instagram.
     *
     * @var string $instagram_access_token
     */
    protected $instagram_access_token = "";

    /**
     * Access token to Facebook.
     *
     * @var string $facebook_access_token
     */
    protected $facebook_access_token = "";

    /**
     * Represents an incorrect access token.
     *
     * @var string $incorrect_access_token
     */
    protected $incorrect_access_token = "1";

    /**
     * This method is called before the first test of this test class is run.
     *
     * @see PHPUnit\Framework\PHPUnit_Framework_TestCase::setUpBeforeClass()
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        
        self::$s_instagram_access_token = InstagramSocialMedia::PARAM_ACCESS_TOKEN;
        self::$s_facebook_access_token = FacebookSocialMedia::PARAM_ACCESS_TOKEN;
        self::$s_app = require __DIR__ . '/../../../app.php';
    }

    /**
     * In addition to creating the application, configure the class with the
     * necessary and common to all the test parameters.
     *
     * @see \Silex\WebTestCase::createApplication()
     */
    public function createApplication()
    {
        $app = self::$s_app;
        $app['debug'] = true;
        $app['exception_handler']->disable();
        
        $instagram_access_token = trim($app[self::$s_instagram_access_token]);
        $facebook_access_token = trim($app[self::$s_facebook_access_token]);
        $this->instagram_access_token = isset($instagram_access_token) ? $instagram_access_token : $this->instagram_access_token;
        $this->facebook_access_token = isset($facebook_access_token) ? $facebook_access_token : $this->facebook_access_token;
        $this->app = $app;
        
        return $app;
    }

    /**
     * The method assert that the response is correct with the expected object.
     *
     * @param Response $response
     *            A Response instance.
     * @param string $media_id_expected
     *            Media id expected
     */
    protected function assertJsonResponse($response, $media_id_expected)
    {
        $this->assertTrue($response->isOk());
        
        $json = json_decode($response->getContent());
        
        $this->assertClassResponse($json);
        $this->assertTrue($json->id == $media_id_expected);
    }

    /**
     * The method assert that the response is correct with the expected format.
     *
     * @param mixed $json
     *            Json response
     */
    protected function assertClassResponse($json)
    {
        $this->assertTrue(isset($json->id));
        $this->assertTrue(isset($json->location));
        $this->assertTrue(isset($json->location->street));
        $this->assertTrue(isset($json->location->city));
        $this->assertTrue(isset($json->location->state));
        $this->assertTrue(isset($json->location->country));
        $this->assertTrue(isset($json->location->zip));
        $this->assertTrue(isset($json->location->latitude));
        $this->assertTrue(isset($json->location->longitude));
        $this->assertTrue(isset($json->location->geopoint->latitude));
        $this->assertTrue(isset($json->location->geopoint->longitude));
    }

    /**
     * The method assert that the expected message is correct.
     *
     * @param Response $response
     *            A Response instance
     * @param string $message
     *            Expected message
     */
    protected function assertJsonMessage($response, $message = false)
    {
        $this->assertTrue($response->isNotFound());
        
        $json = json_decode($response->getContent());
        
        $this->assertTrue(isset($json->message));
        
        if ($message) {
            $this->assertTrue($json->message == $message);
        }
    }

    /**
     * The method simulates a request to get the response.
     *
     * @param string $media_id
     *            The media id
     * @param string $access_token
     *            Access token provided by the social network
     * @param string $network
     *            The type of social network related, for example 'facebook' or
     *            'instragram'. The default is empty.
     */
    protected function getResponse($media_id, $access_token, 
        $network = "")
    {
        $client = $this->createClient();
        $url = '/media/' . $media_id . '?&access_token=' . $access_token;
        $url = (empty($network)) ? $url : $url . '&network=' . $network; 
        
        $client->request('GET', $url);
        
        return $client->getResponse();
    }
}

?>

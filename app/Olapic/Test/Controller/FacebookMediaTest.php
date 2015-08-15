<?php
namespace Olapic\Test\Controller;

use Olapic\Test\Helper\MediaTest;
use Olapic\Controller\MediaControllerProvider;
use Olapic\SocialMedia\FacebookSocialMedia;

/**
 * This unit test was created with the intent of testing the operation of the
 * controller on Facebook.
 *
 * @package \Olapic\Test\Controller
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 *        
 */
class FacebookMediaTest extends MediaTest
{

    /**
     * The media id.
     *
     * @var string $media_id
     */
    protected $media_id = "1";

    /**
     * The type of social network related.
     *
     * @var string $network
     */
    protected $network = "facebook";

    /**
     * This method asserts that the index redirects to the media url.
     */
    public function testIndex()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/?network=' . $this->network);
        $response = $client->getResponse();
        
        $this->assertTrue($response->isRedirect("/media"));
    }

    /**
     * This method tests to the controller when not providing access token.
     */
    public function testWithoutAccessToken()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', 'media/?network=' . $this->network);
        $response = $client->getResponse();
        
        $this->assertJsonMessage($response, 
            MediaControllerProvider::MESSAGE_MEDIA_ID_NOT_FOUND);
    }

    /**
     * This method tests to the controller when not providing access token at
     * all.
     */
    public function testEmptyAllAccessToken()
    {
        $access_token = "";
        $facebook_access_token = $this->app[self::$s_facebook_access_token];
        
        try {
            $this->app[self::$s_facebook_access_token] = "";
            $response = $this->getResponse($this->media_id, $access_token, 
                $this->network);
        } finally {
            $this->app[self::$s_facebook_access_token] = $facebook_access_token;
        }
        
        $this->assertJsonMessage($response);
    }

    /**
     * This method tests to the controller when providing empty access token.
     */
    public function testEmptyAccessToken()
    {
        $access_token = "";
        $response = $this->getResponse($this->media_id, $access_token, 
            $this->network);
        
        $this->assertJsonMessage($response, 
            FacebookSocialMedia::MESSAGE_NOT_IMPLEMENTED);
    }

    /**
     * This method tests to the controller when providing incorrect access
     * token.
     */
    public function testIncorrectAccessToken()
    {
        $response = $this->getResponse($this->media_id, 
            $this->incorrect_access_token, $this->network);
        
        $this->assertJsonMessage($response, 
            FacebookSocialMedia::MESSAGE_NOT_IMPLEMENTED);
    }

    /**
     * This method tests to the controller when providing empty media id.
     */
    public function testWithoutMediaID()
    {
        $media_id = "";
        $response = $this->getResponse($media_id, $this->facebook_access_token, 
            $this->network);
        
        $this->assertJsonMessage($response, 
            MediaControllerProvider::MESSAGE_MEDIA_ID_NOT_FOUND);
    }

    /**
     * This method tests to the controller when providing incorrect media id.
     */
    public function testIncorrectMediaID()
    {
        $response = $this->getResponse($this->media_id, 
            $this->facebook_access_token, $this->network);
        
        $this->assertJsonMessage($response, 
            FacebookSocialMedia::MESSAGE_NOT_IMPLEMENTED);
    }

    /**
     * This method tests to the controller when providing object without
     * location.
     */
    public function testMediaWithoutLocation()
    {
        $response = $this->getResponse($this->media_id, 
            $this->facebook_access_token, $this->network);
        
        $this->assertJsonMessage($response, 
            FacebookSocialMedia::MESSAGE_NOT_IMPLEMENTED);
    }

    /**
     * This method tests to the controller when providing object with location.
     */
    public function testMediaWithLocation()
    {
        $response = $this->getResponse($this->media_id, 
            $this->facebook_access_token, $this->network);
        
        $this->assertJsonMessage($response, 
            FacebookSocialMedia::MESSAGE_NOT_IMPLEMENTED);
    }
}

?>

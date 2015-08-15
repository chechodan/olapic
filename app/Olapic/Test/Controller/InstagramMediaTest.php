<?php
namespace Olapic\Test\Controller;

use Olapic\Test\Helper\MediaTest;
use Olapic\Controller\MediaControllerProvider;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

/**
 * This unit test was created with the intent of testing the operation of the
 * controller on Instagram.
 *
 * @package \Olapic\Test\Controller
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 *        
 */
class InstagramMediaTest extends MediaTest
{

    /**
     * The media id with location.
     *
     * @var string $media_id_with_location
     */
    protected $media_id_with_location = "8";

    /**
     * The media id without location.
     *
     * @var string $media_id_without_location
     */
    protected $media_id_without_location = "21";

    /**
     * Incorrect media id.
     *
     * @var string $incorrect_media_id
     */
    protected $incorrect_media_id = "1";

    /**
     * This method asserts that the index redirects to the media url.
     */
    public function testIndex()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');
        $response = $client->getResponse();
        
        $this->assertTrue($response->isRedirect("/media"));
    }

    /**
     * This method tests to the controller when not providing access token.
     */
    public function testWithoutAccessToken()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', 'media/');
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
        $instagram_access_token = $this->app[self::$s_instagram_access_token];
        $facebook_access_token = $this->app[self::$s_facebook_access_token];
        
        try {
            $this->app[self::$s_instagram_access_token] = "";
            $this->app[self::$s_facebook_access_token] = "";
            $response = $this->getResponse($this->media_id_with_location, 
                $access_token);
        } finally {
            $this->app[self::$s_instagram_access_token] = $instagram_access_token;
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
        $response = $this->getResponse($this->media_id_with_location, 
            $access_token);
        
        $this->assertJsonResponse($response, $this->media_id_with_location);
    }

    /**
     * This method tests to the controller when providing incorrect access
     * token.
     */
    public function testIncorrectAccessToken()
    {
        $response = $this->getResponse($this->media_id_with_location, 
            $this->incorrect_access_token);
        
        $this->assertJsonMessage($response);
    }

    /**
     * This method tests to the controller when providing empty media id.
     */
    public function testWithoutMediaID()
    {
        $media_id = "";
        $response = $this->getResponse($media_id, $this->instagram_access_token);
        
        $this->assertJsonMessage($response, 
            MediaControllerProvider::MESSAGE_MEDIA_ID_NOT_FOUND);
    }

    /**
     * This method tests to the controller when providing incorrect media id.
     */
    public function testIncorrectMediaID()
    {
        $response = $this->getResponse($this->incorrect_media_id, 
            $this->instagram_access_token);
        
        $this->assertJsonMessage($response);
    }

    /**
     * This method tests to the controller when providing object without
     * location.
     */
    public function testMediaWithoutLocation()
    {
        $response = $this->getResponse($this->media_id_without_location, 
            $this->instagram_access_token);
        
        $this->assertJsonMessage($response, 
            MediaControllerProvider::MESSAGE_LOCATION_NOT_FOUND);
    }

    /**
     * This method tests to the controller when providing object with location.
     */
    public function testMediaWithLocation()
    {
        $response = $this->getResponse($this->media_id_with_location, 
            $this->instagram_access_token);
        
        $this->assertJsonResponse($response, $this->media_id_with_location);
    }
}

?>

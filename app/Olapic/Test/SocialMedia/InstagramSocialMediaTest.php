<?php
namespace Olapic\Test\SocialMedia;

use Olapic\Test\Helper\MediaTest;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

/**
 * This unit test was created with the intention of testing the
 * InstagramSocialMedia class.
 *
 * @package \Olapic\Test\SocialMedia
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 *        
 */
class InstagramSocialMediaTest extends MediaTest
{

    /**
     * The media id.
     *
     * @var string $media_id
     */
    protected $media_id = 8;

    /**
     * The media id without location.
     *
     * @var string $media_id
     */
    protected $media_id_without_location = 21;

    /**
     * This method tests getLocation method when providing empty parameter.
     */
    public function testGetLocationEmptyParam()
    {
        $this->setExpectedException('\Exception');
        $instagram = new InstagramSocialMedia(false);
        $location = $instagram->getLocation(false);
    }

    /**
     * This method tests getLocation method when providing empty token and media
     * id.
     */
    public function testGetLocationEmptyTokenEmptyMediaID()
    {
        $this->setExpectedException('\Exception');
        $instagram = new InstagramSocialMedia(array());
        $location = $instagram->getLocation(0);
    }

    /**
     * This method tests getLocation method when not providing token.
     */
    public function testGetLocationWithoutToken()
    {
        $this->setExpectedException('\Exception');
        $instagram = new InstagramSocialMedia(false);
        $location = $instagram->getLocation($this->media_id);
    }

    /**
     * This method tests getLocation method when not providing media id.
     */
    public function testGetLocationWithoutMediaID()
    {
        $this->setExpectedException('\Exception');
        $instagram = new InstagramSocialMedia($this->getArguments());
        $location = $instagram->getLocation(0);
    }

    /**
     * This method tests getLocation method when providing media id without
     * location.
     */
    public function testGetLocationMediaWithoutLocation()
    {
        $instagram = new InstagramSocialMedia($this->getArguments());
        
        $json = $instagram->getLocation($this->media_id_without_location);
        
        $this->assertFalse($json);
    }

    /**
     * This method tests getLocation method when providing media id with
     * location.
     */
    public function testGetLocationMediaWithLocation()
    {
        $instagram = new InstagramSocialMedia($this->getArguments());
        $json = $instagram->getLocation($this->media_id);
        
        $this->assertArrayResponse($json);
    }

    /**
     * Prepare a list of arguments required for the location of the object.
     *
     * @return array Argument list
     */
    protected function getArguments()
    {
        $arg = array();
        $arg[InstagramSocialMedia::PARAM_ACCESS_TOKEN] = $this->instagram_access_token;
        $arg[FacebookSocialMedia::PARAM_ACCESS_TOKEN] = $this->facebook_access_token;
        
        return $arg;
    }

    /**
     * The method assert that the response is correct with the expected format.
     *
     * @param mixed $json
     *            Json response
     */
    protected function assertArrayResponse($json)
    {
        $this->assertTrue(isset($json["id"]));
        $this->assertLocation($json);
    }

    /**
     * The method assert that the response is correct with the expected
     * geopoint.
     *
     * @param mixed $json
     *            Json response
     */
    protected function assertGeopoint($json)
    {
        $this->assertTrue(isset($json["location"]));
        $this->assertTrue(isset($json["location"]["geopoint"]));
        $this->assertTrue(isset($json["location"]["geopoint"]["latitude"]));
        $this->assertTrue(isset($json["location"]["geopoint"]["longitude"]));
    }

    /**
     * The method assert that the response is correct with the expected
     * location.
     *
     * @param mixed $json
     *            Json response
     */
    protected function assertLocation($json)
    {
        $this->assertGeopoint($json);
        
        $this->assertTrue(isset($json["location"]["street"]));
        $this->assertTrue(isset($json["location"]["city"]));
        $this->assertTrue(isset($json["location"]["state"]));
        $this->assertTrue(isset($json["location"]["country"]));
        $this->assertTrue(isset($json["location"]["zip"]));
        $this->assertTrue(isset($json["location"]["latitude"]));
        $this->assertTrue(isset($json["location"]["longitude"]));
    }
}

?>

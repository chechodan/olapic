<?php
namespace Olapic\Test\SocialMedia;

use Olapic\Test\Helper\MediaTest;
use Olapic\SocialMedia\FacebookSocialMedia;

/**
 * This unit test was created with the intention of testing the
 * FacebookSocialMedia class.
 *
 * @package \Olapic\Test\SocialMedia
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 *        
 */
class FacebookSocialMediaTest extends MediaTest
{

    /**
     * This method tests getLocation method.
     */
    public function testGetLocation()
    {
        $this->setExpectedException('\Exception');
        $facebook = new FacebookSocialMedia(false);
        $facebook->getLocation(0);
    }

    /**
     * This method tests getLocationInfo method when providing empty parameters.
     */
    public function testGetLocationInfoEmptyParam()
    {
        $lat = "";
        $lng = "";
        $access_token = $this->facebook_access_token;
        
        $this->assertGeopointLatLng(
            FacebookSocialMedia::getLocationInfo($lat, $lng, $access_token), 
            $lat, $lng);
    }

    /**
     * This method tests getLocationInfo method when providing incorrect
     * parameters.
     */
    public function testGetLocationInfoGarbageParam()
    {
        $lat = "aaaa";
        $lng = "bbbb";
        $access_token = $this->facebook_access_token;
        
        $this->assertGeopointLatLng(
            FacebookSocialMedia::getLocationInfo($lat, $lng, $access_token), 
            $lat, $lng);
    }

    /**
     * This method tests getLocationInfo method when providing incorrect
     * parameters.
     */
    public function testGetLocationInfoErrorParam()
    {
        $lat = "0";
        $lng = "0";
        $access_token = $this->facebook_access_token;
        
        $this->assertGeopointLatLng(
            FacebookSocialMedia::getLocationInfo($lat, $lng, $access_token), 
            $lat, $lng);
    }

    /**
     * This method tests getLocationInfo method.
     */
    public function testGetLocationInfo()
    {
        $lat = "37.777348";
        $lng = "-122.404654";
        $access_token = $this->facebook_access_token;
        
        $this->assertLocationLatLng(
            FacebookSocialMedia::getLocationInfo($lat, $lng, $access_token), 
            $lat, $lng);
    }

    /**
     * The method assert that the response is correct with the expected
     * geopoint, latitude and longitude.
     *
     * @param mixed $json
     *            Json response
     * @param number $lat
     *            Latitude
     * @param number $lng
     *            Longitude
     */
    protected function assertGeopointLatLng($json, $lat, $lng)
    {
        $this->assertGeopoint($json);
        $this->assertTrue($json["geopoint"]["latitude"] == $lat);
        $this->assertTrue($json["geopoint"]["longitude"] == $lng);
    }

    /**
     * The method assert that the response is correct with the expected
     * location, latitude and longitude.
     *
     * @param mixed $json
     *            Json response
     * @param number $lat
     *            Latitude
     * @param number $lng
     *            Longitude
     */
    protected function assertLocationLatLng($json, $lat, $lng)
    {
        $this->assertLocation($json);
        $this->assertTrue($json["geopoint"]["latitude"] == $lat);
        $this->assertTrue($json["geopoint"]["longitude"] == $lng);
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
        $this->assertTrue(isset($json["geopoint"]));
        $this->assertTrue(isset($json["geopoint"]["latitude"]));
        $this->assertTrue(isset($json["geopoint"]["longitude"]));
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
        
        $this->assertTrue(isset($json["street"]));
        $this->assertTrue(isset($json["city"]));
        $this->assertTrue(isset($json["state"]));
        $this->assertTrue(isset($json["country"]));
        $this->assertTrue(isset($json["zip"]));
        $this->assertTrue(isset($json["latitude"]));
        $this->assertTrue(isset($json["longitude"]));
    }
}

?>

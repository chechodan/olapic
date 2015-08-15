<?php
namespace Olapic\Test\SocialMedia;

use Olapic\Test\Helper\MediaTest;
use Olapic\SocialMedia\SocialMedia;
use Olapic\SocialMedia\SocialMediaNetwork;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

/**
 * This unit test was created with the intention of testing the SocialMedia class.
 * 
 * @package \Olapic\Test\SocialMedia
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 *
 */
class SocialMediaTest extends MediaTest
{

    /**
     * Constant representing the key parameter in the argument list.
     * 
     * @var string PARAM_TEST
     */
    const PARAM_TEST = "test_param";

    /**
     * Constant representing the parameter value.
     *
     * @var string PARAM_TEST
     */
    const PARAM_TEST_VALUE = "value";

    /**
     * The media id.
     *
     * @var string $media_id
     */
    protected $media_id = 8;

    /**
     * A SocialMedia instance.
     *
     * @var SocialMedia $social
     */
    protected $social = false;

    /**
     * Configure SocialMedia.
     * 
     * @see \Silex\WebTestCase::setUp()
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->social = new SocialMedia(
            array(
                self::PARAM_TEST => self::PARAM_TEST_VALUE
            ));
    }

    /**
     * This method tests the arguments supplied in the constructor.
     */
    public function testArguments()
    {
        $arg = $this->social->getArgument();
        
        $this->assertTrue(
            isset($arg[self::PARAM_TEST]) &&
                 $arg[self::PARAM_TEST] == self::PARAM_TEST_VALUE);
    }

    /**
     * This method tests the getter Network.
     */
    public function testNetwork()
    {
        $this->assertFalse($this->social->getNetwork());
    }

    /**
     * This method tests the setter Network.
     */
    public function testSetterNetwork()
    {
        $this->social->setNetwork(SocialMediaNetwork::INSTAGRAM);
        
        $this->assertTrue(
            $this->social->getNetwork() == SocialMediaNetwork::INSTAGRAM);
    }

    /**
     * This method tests the getLocation.
     */
    public function testInstagramLocation()
    {
        $this->social->setNetwork(SocialMediaNetwork::INSTAGRAM);
        $this->social->getLocation($this->media_id, $this->getArguments());
        
        $this->assertTrue(
            $this->social->getSocialMedia() instanceof InstagramSocialMedia);
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
}

?>

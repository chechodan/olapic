<?php
namespace Olapic\Test\SocialMedia;

use Olapic\Test\Helper\MediaTest;
use Olapic\SocialMedia\SocialMedia;
use Olapic\SocialMedia\SocialMediaNetwork;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

/**
 * This unit test was created with the intention of testing the
 * SocialMediaNetwork class.
 *
 * @package \Olapic\Test\SocialMedia
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 *        
 */
class SocialMediaNetworkTest extends MediaTest
{

    /**
     * This method tests createSocialMedia method when providing empty
     * parameter.
     */
    public function testCreateSocialMediaEmptyParam()
    {
        $social = SocialMediaNetwork::createSocialMedia(false);
        
        $this->assertTrue($social instanceof InstagramSocialMedia);
    }

    /**
     * This method tests createSocialMedia method when providing empty array.
     */
    public function testCreateSocialMediaEmptyArray()
    {
        $social = SocialMediaNetwork::createSocialMedia(array());
        
        $this->assertTrue($social instanceof InstagramSocialMedia);
    }

    /**
     * This method tests createSocialMedia method for Instagram.
     */
    public function testCreateSocialMediaInstagram()
    {
        $social = SocialMediaNetwork::createSocialMedia(
            array(
                SocialMedia::PARAM_NETWORK => SocialMediaNetwork::INSTAGRAM
            ));
        
        $this->assertTrue($social instanceof InstagramSocialMedia);
    }

    /**
     * This method tests createSocialMedia method for Facebook.
     */
    public function testCreateSocialMediaFacebook()
    {
        $social = SocialMediaNetwork::createSocialMedia(
            array(
                SocialMedia::PARAM_NETWORK => SocialMediaNetwork::FACEBOOK
            ));
        
        $this->assertTrue($social instanceof FacebookSocialMedia);
    }
}

?>

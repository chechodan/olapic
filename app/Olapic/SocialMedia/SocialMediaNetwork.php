<?php
namespace Olapic\SocialMedia;

/**
 * This class is utility to the context of the Strategy pattern
 * ({@link SocialMedia}).
 * It includes all referred to the implementation of the
 * model.
 *
 * @package \Olapic\SocialMedia
 * @copyright 2015 Sergio Liendo
 * @see \Olapic\SocialMedia\SocialMedia
 * @author Sergio Liendo
 *        
 */
class SocialMediaNetwork
{

    /**
     * Constant that refers to the implementation of Instagram.
     * 
     * @var string INSTAGRAM
     */
    const INSTAGRAM = "instragram";

    /**
     * Constant that refers to the implementation of Facebook.
     * 
     * @var string FACEBOOK
     */
    const FACEBOOK = "facebook";

    /**
     * This method creates a concrete strategy according to the context in which
     * is included in the list of arguments.
     *
     * @param array $arg
     *            Argument list
     * @return \Olapic\SocialMedia\SocialMediaInterface|false A
     *         SocialMediaInterface implementation
     */
    public static function createSocialMedia($arg)
    {
        $social_media = false;
        $network = isset($arg[SocialMedia::PARAM_NETWORK]) ? $arg[SocialMedia::PARAM_NETWORK] : false;
        
        switch ($network) {
            case self::FACEBOOK:
                $social_media = new FacebookSocialMedia($arg);
                break;
            case self::INSTAGRAM:
            default:
                $social_media = new InstagramSocialMedia($arg);
                break;
        }
        
        return $social_media;
    }
}

?>

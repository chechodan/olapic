<?php
namespace Olapic\SocialMedia;

/**
 * This class makes reference to the context of the Strategy pattern, which
 * generalizes the getLocation method for ease of use.
 * This class abstracts the implementation of the
 * {@link SocialMediaInterface} interface. Regard to implementation, is 
 * contained in the class {@link SocialMediaNetwork}.
 *
 * @package \Olapic\SocialMedia
 * @copyright 2015 Sergio Liendo
 * @see \Olapic\SocialMedia\SocialMediaNetwork
 * @see \Olapic\SocialMedia\SocialMediaInterface
 * @author Sergio Liendo
 *        
 */
class SocialMedia
{

    /**
     * Constant representing the key parameter in the argument list.
     *
     * @var string PARAM_NETWORK
     */
    const PARAM_NETWORK = "network";

    /**
     * A SocialMediaInterface implementation.
     *
     * @var SocialMediaInterface $social_media
     */
    private $social_media;

    /**
     * Argument list.
     *
     * @var array $arg
     */
    private $arg;

    /**
     * The constructor.
     *
     * @param array $arg
     *            Argument list
     */
    public function __construct($arg)
    {
        $this->arg = $arg;
    }

    /**
     * Setter to network.
     *
     * @param string $network
     *            The type of social network related, for example 'facebook' or
     *            'instragram'
     * @return \Olapic\SocialMedia\SocialMedia The class itself
     */
    public function setNetwork($network)
    {
        $this->arg[self::PARAM_NETWORK] = $network;
        
        unset($this->social_media);
        
        return $this;
    }

    /**
     * Getter to Argument.
     *
     * @return array|false Argument list
     */
    public function getArgument()
    {
        return isset($this->arg) ? $this->arg : false;
    }

    /**
     * Getter to Network.
     *
     * @return string|false The network
     */
    public function getNetwork()
    {
        return (isset($this->arg[self::PARAM_NETWORK])) ? $this->arg[self::PARAM_NETWORK] : false;
    }

    /**
     * Getter to SocialMedia
     *
     * @return SocialMediaInterface The SocialMediaInterface implementation
     */
    public function getSocialMedia()
    {
        return $this->social_media;
    }

    /**
     * Generalized method for the location of an object according to how it is
     * set up.
     *
     * @param string $media_id            
     * @param array $arg            
     * @return array The location information
     * @see \Olapic\SocialMedia\SocialMediaInterface::getLocation()
     */
    public function getLocation($media_id, $arg = false)
    {
        $arg = ($arg) ? $arg : $this->arg;
        
        if (! isset($this->social_media)) {
            $this->social_media = SocialMediaNetwork::createSocialMedia($arg);
        }
        
        return $this->social_media->getLocation($media_id, $arg);
    }
}

?>

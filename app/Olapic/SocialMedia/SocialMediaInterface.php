<?php
namespace Olapic\SocialMedia;

/**
 * The strategy is implemented via an interface, which defines a getLocation
 * method.
 * This method is the algorithm that must be implemented in concrete strategies,
 * according to the respective social network.
 *
 * @package \Olapic\SocialMedia
 * @copyright 2015 Sergio Liendo
 * @author Sergio Liendo
 *        
 */
interface SocialMediaInterface
{

    /**
     * The function of this method is to seek information regarding the location
     * of the object.
     *
     * @param string $media_id
     *            The media id
     * @param array $arg
     *            Argument list
     * @return array|false The location information
     */
    public function getLocation($media_id, $arg = array());
}

?>

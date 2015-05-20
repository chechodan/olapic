<?php
namespace Olapic\Test\Helper;

use Silex\WebTestCase;
use Olapic\Controller\MediaControllerProvider;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

class MediaTest extends WebTestCase 
{  
    protected static $s_app;
    protected static $s_instagram_access_token;
    protected static $s_facebook_access_token;
    protected $instagram_access_token = "";
    protected $facebook_access_token = "";
    protected $incorrect_access_token = "1";
  
    public static function setUpBeforeClass() 
    {
        parent::setUpBeforeClass();
        
        self::$s_instagram_access_token = 
            InstagramSocialMedia::PARAM_ACCESS_TOKEN;
        self::$s_facebook_access_token = 
            FacebookSocialMedia::PARAM_ACCESS_TOKEN;
        self::$s_app = require __DIR__.'/../../../app.php';
    }

    public function createApplication()
    {
        $app = self::$s_app;
        $app['debug'] = true;
        $app['exception_handler']->disable(); 
        
        $instagram_access_token = trim($app[self::$s_instagram_access_token]);
        $facebook_access_token = trim($app[self::$s_facebook_access_token]);
        $this->instagram_access_token = isset($instagram_access_token) ? 
                       $instagram_access_token : $this->instagram_access_token;
        $this->facebook_access_token = isset($facebook_access_token) ? 
                       $facebook_access_token : $this->facebook_access_token;
        $this->app = $app;
        
        return $app;
    }
 
    protected function assertJsonResponse($response)
    { 
        $this->assertTrue($response->isOk());

        $json = json_decode($response->getContent());
     
        $this->assertClassResponse($json);   
        $this->assertTrue($json->id == $this->media_id_with_location);
    }

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

    protected function assertJsonMessage($response, $message = false)
    {
        $this->assertTrue($response->isNotFound());  

        $json = json_decode($response->getContent());

        $this->assertTrue(isset($json->message)); 

        if ($message) {
            $this->assertTrue($json->message == $message);
        }
    }

    protected function getResponse($media_id, $access_token){
        $client = $this->createClient();
        
        $client->request(
                         'GET', 
                         '/media/'.$media_id.'?access_token='.$access_token
                        );
        
        return $client->getResponse();
    }
}

?>

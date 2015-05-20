<?php

namespace Olapic\Test\Controller;

use Olapic\Test\Helper\MediaTest;
use Olapic\Controller\MediaControllerProvider;
use Olapic\SocialMedia\FacebookSocialMedia;

class FacebookMediaTest extends MediaTest 
{
    protected $media_id = "1";

    public function testIndex() 
    {  
        $client = $this->createClient();
        $crawler = $client->request('GET', '/?network=facebook');  
        $response = $client->getResponse();
        
        $this->assertTrue($response->isRedirect("/media"));  
    }
  
    public function testWithoutAccessToken() 
    {  
        $client = $this->createClient();
        $crawler = $client->request('GET', 'media/?network=facebook');  
        $response = $client->getResponse();
        
        $this->assertJsonMessage(
                          $response, 
                          MediaControllerProvider::MESSAGE_MEDIA_ID_NOT_FOUND
        );
    }

    public function testEmptyAllAccessToken()
    {
        $access_token = "";
        $facebook_access_token  = $this->app[self::$s_facebook_access_token];

        try {
            $this->app[self::$s_facebook_access_token]="";
            $response = $this->getResponse($this->media_id, $access_token); 
        } finally {
            $this->app[self::$s_facebook_access_token] = $facebook_access_token;
        }
          
        $this->assertJsonMessage($response);
    }

    public function testEmptyAccessToken()
    {
        $access_token="";
        $response = $this->getResponse($this->media_id, $access_token); 
        
        $this->assertJsonMessage(
                $response, 
                FacebookSocialMedia::MESSAGE_NOT_IMPLEMENTED
        );
    }
   
    public function testIncorrectAccessToken() 
    {
        $response = $this->getResponse(
                        $this->media_id, 
                        $this->incorrect_access_token
                    ); 
        
        $this->assertJsonMessage(
                $response, 
                FacebookSocialMedia::MESSAGE_NOT_IMPLEMENTED);
    } 
  
    public function testWithoutMediaID() 
    {  
        $media_id = "";
        $response = $this->getResponse($media_id, $this->facebook_access_token);  
        
        $this->assertJsonMessage(
                $response, 
                MediaControllerProvider::MESSAGE_MEDIA_ID_NOT_FOUND
        );
    }

    public function testIncorrectMediaID()
    {  
        $response = $this->getResponse(
                        $this->media_id, 
                        $this->facebook_access_token
                    );  

        $this->assertJsonMessage(
                $response, 
                FacebookSocialMedia::MESSAGE_NOT_IMPLEMENTED
        );
    }

    public function testMediaWithoutLocation()
    {
        $response = $this->getResponse(
                        $this->media_id, 
                        $this->facebook_access_token
                    );  
       
        $this->assertJsonMessage(
                $response, 
                FacebookSocialMedia::MESSAGE_NOT_IMPLEMENTED
        );
    }
  
    public function testMediaWithLocation()
    {
        $response = $this->getResponse(
                        $this->media_id, 
                        $this->facebook_access_token
                    ); 

        $this->assertJsonMessage(
                $response, 
                FacebookSocialMedia::MESSAGE_NOT_IMPLEMENTED
        );
    }  
  
    protected function getResponse($media_id, $access_token)
    {
        $client = $this->createClient();
        
        $client->request(
            'GET', 
            '/media/'.$media_id.'?network=facebook&access_token='.$access_token
        );
        
        return $client->getResponse();
    }
}

?>

<?php

namespace Olapic\Test\Controller;

use Olapic\Test\Helper\MediaTest;
use Olapic\Controller\MediaControllerProvider;
use Olapic\SocialMedia\InstagramSocialMedia;
use Olapic\SocialMedia\FacebookSocialMedia;

class InstagramMediaTest extends MediaTest
{
  
  protected $media_id_with_location = "12";
  protected $media_id_without_location = "21";
  protected $incorrect_media_id = "1";

  public function testIndex() {  
    $client = $this->createClient();
    $crawler = $client->request('GET', '/');  
    $response = $client->getResponse();
    
    $this->assertTrue($response->isRedirect("/media"));  
  }
  
  public function testWithoutAccessToken() {  
    $client = $this->createClient();
    $crawler = $client->request('GET', 'media/');  
    $response = $client->getResponse();
    
    $this->assertJsonMessage($response, MediaControllerProvider::MESSAGE_MEDIA_ID_NOT_FOUND);
  }

  public function testEmptyAllAccessToken() {
    $access_token = "";
    $instagram_access_token = $this->app[self::$_instagram_access_token];
    $facebook_access_token  = $this->app[self::$_facebook_access_token];

    try
    {
      $this->app[self::$_instagram_access_token]="";
      $this->app[self::$_facebook_access_token]="";
      $response = $this->getResponse($this->media_id_with_location, $access_token); 
    } finally
    {
      $this->app[self::$_instagram_access_token] = $instagram_access_token;
      $this->app[self::$_facebook_access_token] = $facebook_access_token;  
    }
      
    $this->assertJsonMessage($response);
  }

  public function testEmptyAccessToken() {
    $access_token="";
    $response = $this->getResponse($this->media_id_with_location, $access_token); 
    
    $this->assertJsonResponse($response);
  }
  
 
  public function testIncorrectAccessToken() {
    $response = $this->getResponse($this->media_id_with_location, $this->incorrect_access_token); 

    $this->assertJsonMessage($response);
  } 
  
  public function testWithoutMediaID() {  
    $media_id = "";
    $response = $this->getResponse($media_id, $this->instagram_access_token);  
    
    $this->assertJsonMessage($response, MediaControllerProvider::MESSAGE_MEDIA_ID_NOT_FOUND);
  }

  public function testIncorrectMediaID() {  
    $response = $this->getResponse($this->incorrect_media_id, $this->instagram_access_token);  

    $this->assertJsonMessage($response);
  }

  public function testMediaWithoutLocation() {
    $response = $this->getResponse($this->media_id_without_location, $this->instagram_access_token);  
   
     $this->assertJsonMessage($response, MediaControllerProvider::MESSAGE_LOCATION_NOT_FOUND);   
  }
  
  public function testMediaWithLocation() {
    $response = $this->getResponse($this->media_id_with_location, $this->instagram_access_token); 

    $this->assertJsonResponse($response);
  }  
}
?>

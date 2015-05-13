<?php

use Silex\WebTestCase;
use Olapic\Controller\MediaControllerProvider;

class MediaTest extends WebTestCase {

  protected $access_token="";
  protected $media_id_with_location = "12";
  protected $media_id_without_location = "21";
  protected $incorrect_media_id = "1";
  protected $incorrect_access_token = "1";
  
  public function createApplication() {
    $app = require __DIR__.'/../../app.php';
    $app['debug'] = true;
    $app['exception_handler']->disable();
    
    return $app;
  }

  public function testEmptyAccessToken() {
    $access_token = "";
    $response = $this->getResponse($this->media_id_with_location, $access_token); 
    $this->assertTrue($response->isNotFound());
 
    $json = json_decode($response->getContent());
    
    $this->assertTrue(isset($json->message));
    $this->assertTrue($json->message == MediaControllerProvider::MESSAGE_ACCESS_TOKEN_INVALID);      
  }
 
  public function testIncorrectAccessToken() {
    $response = $this->getResponse($this->media_id_with_location, $this->incorrect_access_token); 
    $this->assertTrue($response->isNotFound());
 
    $json = json_decode($response->getContent());
    
    $this->assertTrue(isset($json->message));
  } 
  
  public function testWithoutMediaID() {  
    $media_id = "";
    $response = $this->getResponse($media_id, $this->access_token);  
    
    $this->assertTrue($response->isNotFound());  
    
    $json = json_decode($response->getContent());
    
    $this->assertTrue(isset($json->message));
    $this->assertTrue($json->message == MediaControllerProvider::MESSAGE_MEDIA_ID_NOT_FOUND);
  }

  public function testIncorrectMediaID() {  
    $response = $this->getResponse($this->incorrect_media_id, $this->access_token);  
    $this->assertTrue($response->isNotFound()); 

    $json = json_decode($response->getContent());
    
    $this->assertTrue(isset($json->message)); 
  }

  public function testMediaWithoutLocation() {
    $response = $this->getResponse($this->media_id_without_location, $this->access_token);  
    $this->assertTrue($response->isNotFound());  
    
    $json = json_decode($response->getContent());
    
    $this->assertTrue(isset($json->message)); 
    $this->assertTrue($json->message == MediaControllerProvider::MESSAGE_LOCATION_NOT_FOUND);
  }
  
  public function testMediaWithLocation() {
    $response = $this->getResponse($this->media_id_with_location, $this->access_token); 
    
    $this->assertTrue($response->isOk());  
    
    $json = json_decode($response->getContent());
    
    $this->assertTrue(isset($json->id));
    $this->assertTrue(isset($json->location));
    $this->assertTrue(isset($json->location->geopoint));
    $this->assertTrue(isset($json->location->geopoint->latitude));
    $this->assertTrue(isset($json->location->geopoint->longitude));
    $this->assertTrue($json->id == $this->media_id_with_location);
  }

  protected function getResponse($media_id, $access_token){
    $client = $this->createClient();
    $crawler = $client->request('GET', 'media/'.$media_id.'?access_token='.$access_token);
    
    return $client->getResponse();
  }
}
?>

# Olapic Project

The project consists in providing a service to take the location of a photo or video from a social network.
The service is accessed by the url 'media/{media_id}' where 'media_id' is the id of the photo or video required.
It is necessary to add a parameter to the authorization called 'access_token'. This parameter is obtained out of the application after login to the social network that you want to use.

The type of social network involved can be added as optional parameter called 'network', for example network=instagram or network=facebook. By default this parameter is 'instagram'.
So the request could be formed in the following ways:

```
instagram => GET media/12345?access_token=TOKEN 
facebook  => GET media/12345?access_token=TOKEN&network=facebook
```

The response will be in the following way:

```
STATUS 200
{
  "id": 12345,
  "location": {
    "geopoint": {
      "latitude": 42.277,
      "longitude": -71.9256
    }
  }
}
```

## Requirements

* php 5.4+
* apache 2.2.16+

## Run project 

`php -S localhost:8080 -t web web/index.php`

Now the application should be running at <http://localhost:8080>.
For other ways to start the application refer to the following [link](http://silex.sensiolabs.org/doc/web_servers.html)

## Testing

To run the test, you must configure the class "MediaTest" and add the access token. Then run the command "./app/phpunit - c app/" to start the test.

## Configuration on Debian

You need to configure apache and domain name, as follows:

* In the file '/etc/hosts' add the following line '127.0.0.1 olapic'
* In the file '/etc/apache2/sites-available/000-default.conf' add the following lines:

  ```
  <VirtualHost *:80>
    DocumentRoot "/var/www/html/olapic/web"
    ServerName olapic
    <Directory "/var/www/html/olapic/web">
      AllowOverride All
    </Directory>
  </VirtualHost>
  ```

  Then restart the apache server:

  `sudo service apache2 restart`

* Composer must be installed in the project folder:

  `curl -sS https://getcomposer.org/installer | php`

  Then install dependencies:

  `php composer.phar install`

Done! In the browser goto: 

`<olapic/media/{media_id}?access_token={TOKEN}&network={instagram|facebook}> (The network parameter is optional, default is 'instagram').`

## Silex Web Framework

The silex web framework was used for this project. It was organised in such a way that use the controller provider, to handle the request with the 'media' route. This controller is located in the file 'app/Olapic/Controller/MediaControllerProvider.php'. The reason for this controller is to keep the code clean and with a structure that will allow us to extend and scale the project.
For more information you can access the official website <http://silex.sensiolabs.org/>.

## PHP Instagram API

This is a PHP 5.3+ API wrapper for the Instagram API. This api was used to implement the concrete strategy of the 'SocialMedia' module for Instagram. The choice of this API is that it has functions to discover the location of media.

For more information, goto <https://github.com/galen/PHP-Instagram-API>

## SocialMedia

'SocialMedia' is a module created with the [Strategy pattern](http://en.wikipedia.org/wiki/Strategy_pattern), to allow different implementations according to the social network, to obtain the location of a photo or video.

The strategy is implemented via an interface (SocialMediaInterface), which defines a getLocation method. This method is the algorithm that must be implemented in concrete strategies, according to the respective social network. For example for instagram, was implemented the interface in the InstagramSocialMedia class, and for facebook, it was implemented in the FacebookSocialMedia class.

The context was implemented in two classes. On the one hand, the SocialMediaNetwork class defines respective constants to social networks that were implemented. The method 'create_social_media', selects the algorithm to be used according to the parameter 'network' within the 'args' array passed by parameter in the function. The objective of this class is to be more easily add a new implementation. On the other hand, the context is defined in the SocialMedia class, which generalizes the method getLocation, and according to the social network, the correct algorithm is selected to run.

Every algorithm could require different parameters to configure the process, so in the method 'getLocation' there is an optional parameter called args to this end, and in the constructor of the class, an arguments array is configured by default.

It is important to note, that the implementation of facebook is not made. The class was added for use as an example in the strategy pattern. So an exception is thrown when you try to use it.

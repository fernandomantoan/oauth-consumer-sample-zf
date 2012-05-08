# OAuth Consumer with Zend Framework
This project is a simple billing management system, to be used as a sample of implementation of an OAuth 1.0a consumer, using Zend Framework. It's main purpose is to consume the endpoint defined in the [oauth-provider-sample project](https://github.com/fernandomantoan/oauth-provider-sample).

## Pre-requisites
An Apache HTTP server with PHP 5.2+ and MySQL Server.

## Configuration
In the **application/configs/application.ini** file you must configure the resources.db parameters, matching your database server configuration. The **database.sql** file contains the table needed by the application, where the bills will be stored.

There are some OAuth configurations needed by the application, they are:

	oauth.siteUrl = "http://localhost:8080/oauth-provider-sample/oauth"
	oauth.authorizeUrl = "http://localhost:8080/oauth-provider-sample/oauth/confirm_access"
	oauth.callback = "http://localhost/oauth-consumer-sample-zf/auth/callback"
	oauth.consumerKey = "bills-consumer-key"
	oauth.consumerSecret = "oauth-tcc-secret-01"

Where the **siteUrl** and **authorizeUrl** parameters should be configured to your OAuth endpoint address, the first is the root of your OAuth server, and the second the URL of the access confirmation endpoint. The **callback** parameter should be your Apache HTTP server address and the path to this consumer, maintaning the **auth/callback** part, as it maps to the **AuthController** class and its **callbackAction()** method.

The **consumerKey** and **consumerSecret** must be configured to match the key/secret configured in your OAuth server.

The two last configurations are the following:

	userService.endpoint = "http://localhost:8080/oauth-provider-sample/user/info"
	userService.logout = "http://localhost:8080/oauth-provider-sample/logout.do"

These parameters refer to the a user service endpoint, which will provide the user details service, that must return a JSON, and the logout functionality. Remember that this project was developed in a SSO study, that's why the logout URL is defined to a remote server, which handles the authentication.

## Usage

After the consumer configuration, you should point your browser to the consumer address, and when not authenticated, the application will redirect you to login and authorize it in the OAuth server configured. It is done in a combination of a controller plugin called **FernandoMantoan_Auth_OAuth_Plugin** which changes the routes parameters and the **AuthController** that will create a request token and use the Zend_Oauth_Consumer to redirect to user to ask for authorization. If you do not authorize, nothing will happen, as the callback URL won't have the authenticity tokens.

When the application is authorized, the OAuth server should redirect the browser to the callback URL, containing all the needed tokens. The callback is defined in the **callbackAction()** method, of the **AuthController** class. The application will then map all the tokens, and store an access token in the session. After that, it will make a POST request to the user service details, map the JSON response and store in the Zend_Auth component.

After all this flow, the user can operate on its bills, making simple operations such as creating new bills, editing existing bills and deleting their bills.

## Improvements

The consumer could store the access token and implement an expiration verification, so that the OAuth endpoint wouldn't ask for authorization everytime that the login is prompted.

## Monograph

The full monograph document can be found in my [blog](http://fernandomantoan.com/monografia-2/estudo-de-caso-de-uma-estrutura-de-autenticacao-unica-utilizando-o-protocolo-oauth/) and it's written in Brazilian Portuguese. The result of the monograph are three main applications, stored in github:

* An [OAuth server](https://github.com/fernandomantoan/oauth-provider-sample), which uses [Spring Framework](http://www.springsource.org) with many other libraries;
* A [bills management system](https://github.com/fernandomantoan/oauth-consumer-sample-zf), which uses [Zend Framework](http://framework.zend.com) and Zend_Oauth_Consumer component;
* A [contacts management system](https://github.com/fernandomantoan/oauth-consumer-sample-play), which uses [Play! Framework](http://www.playframework.org) and the OAuth module.
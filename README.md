# vdm-scraper
A simple Vdm web scraper in Laravel 5.1 [VDM](http://www.viedemerde.fr/?page=0)

## Installing

1. Install Laravel 5.1 [Laravel Doc](http://laravel.com/docs/5.1)
2. Clone this repository
3. Pick your favorite database option in the config/database.php file
4. Set up the database properties in your own vdm-scraper/.env file
5. Install all composer packages using the composer.json file included

**Extra help**

* Don't forget to run **composer install** and **composer update** to build dependencies.
* If you run into a cipher error try **php artisan generate:key**

##Usage

**Fetching VDM articles**

Use the command **php artisan vdm:scrap** from the root directory to save the 200 last VDM posts into the database.

**Using the API**

VDM posts are accessible with different parameters and using different routes

* **/api/posts** : *lists all the posts*

```json
{
	"post": 
	[
		{
			"id":1,
			"content":"Aujourd'hui, mon beau fils de 4 ans me demande si je suis sa nouvelle maman. Je lui explique donc qu'on n'a qu'une seule maman et que je suis sa belle-maman. Bah moi, je te trouve moche. VDM",
			"date":"2015-11-18 12:56:00",
			"author":"apaogi"
		}
	],
	"count":1
}
```


* **/api/posts/id** : *lists one post given its internal id (not his actual vdm id)*

```json
{
	"post":
	{
		"id":1,
		"content":"Aujourd'hui, mon beau fils de 4 ans me demande si je suis sa nouvelle maman. Je lui explique donc qu'on n'a qu'une seule maman et que je suis sa belle-maman. Bah moi, je te trouve moche. VDM",
		"date":"2015-11-18 12:56:00",
		"author":"apaogi"
	}
}
```

* **/api/posts?from=yyyy-mm-dd** : *lower limit to filter posts by date*
* **/api/posts?to=yyyy-mm-dd** : *upper limit to filter posts by date*
* **/api/posts?author=name** : *lists all posts for given author name*

**Unit Testing**

Several tests are ready to be run for Scraper.php and VdmController.php, for this go to the root folder and execute the **vendor/bin/phpunit tests/file.php**.


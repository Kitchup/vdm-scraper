<?php 

namespace App\Vdm;

// Composer lib used to extract contents from HTML pages
use Sunra\PhpSimple\HtmlDomParser;
// Post model
use App\Post;
use Underscore\Types\Arrays;
use Carbon\Carbon;

/**
* Fetches, extracts, formats and saves www.viedemerde.fr articles into Post models
*
* @package App\Vdm
*/

class Scraper
{
	/**
	* Base website url for specific Vdm page
	*
	* @var string
	*/
	private $baseUrl = "http://www.viedemerde.fr?page=%d";

	/**
	* Getter for baseUrl
	*
	* @return string
	*/
	public function getBaseUrl(){return $this->baseUrl;}

	/**
	* Setter for baseUrl
	*
	* @param string $url
	* @return       $this
	*/
	public function setBaseUrl($url){
		$this->baseUrl=$url;
		return $this;
	}	

	/**
	* Retrieves the last $postCount articles from vdm and saves them into the database
	*
	* @param  int $postCount : the number of entries to retrieve
	* @return array<Post>
	*/
	public function scrap($postCount)
	{
		$articles = Scraper::getLatestPosts($postCount);

		return Arrays::each($articles, function($article){ return Scraper::persistPost($article); });
	}

	/**
	* Creates corresponding Post model for given DOM object
	*
	* @param  $article : the DOM object
	* @return $post    : Properly formated Post entity
	*/
	protected function persistPost($article)
	{
		$post = new Post();
		$post->content = Scraper::parseContent($article);
		$post->date = Scraper::parseDate($article);
		$post->author = Scraper::parseAuthor($article);
		$post->vdm_id = Scraper::parseVdmId($article);

		return $post;
	}

	/**
	* Crawls a DOM object to retrieve its content
	*
	* @param  $article : the DOM object
	* @return String 
	*/
	protected function parseContent($article)
	{
		return trim($article->find('p',0)->plaintext);
	}

	/**
	* Crawls a DOM object to retrieve its date and formats it properly
	*
	* @param  $article : the DOM object
	* @return String 
	*/
	protected function parseDate($article)
	{
		$dateDiv = $article->find('.date',0)->plaintext;
		// 2 digits followed by a / followed by 2 digits...
		preg_match("/(\d{2}[\/]{1}\d{2}[\/]{1}\d{4})(.*)(\d{2}[:]{1}\d{2})/i", $dateDiv, $matches);

		return Carbon::createFromFormat('d/m/Y à H:i', $matches[0])->toDateTimeString();
	}

	/**
	* Crawls a DOM object to retrieve its author
	*
	* @param  $article : the DOM object
	* @return String 
	*/
	protected function parseAuthor($article)
	{
		$dateDiv = $article->find('.date',0)->find('p',1)->plaintext;
		// String starting by 'par', followed by a space, composed by a combinaison of any amount of the listed characters
		preg_match("/par\s+([a-zA-Z0-9_\-\.\s\#áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸ]+)/i", $dateDiv, $matches);

		return trim($matches[1]);
	}

	/**
	* Crawls a DOM object to retrieve its vdm_id
	*
	* @param  $article : the DOM object
	* @return String 
	*/
	protected function parseVdmId($article)
	{
		return $article->id;
	}

	/**
	* Retrieves the last $postCount from vdm
	*
	* @param  int $postCount : the number of entries to retrieve
	* @return mixed
	*/
	protected function getLatestPosts($postCount)
	{
		// posts array is empty
		$posts = [];
		// starting at page 0 (source achitecture)
		$pageId = 0;

		// fetching until enough posts are retrieved
		while (Arrays::size($posts) < $postCount)
		{
			$dom = HtmlDomParser::file_get_html(sprintf($this->getBaseUrl(), $pageId));
			$domPosts = $dom->find('.article');
			$posts = Arrays::merge($posts, $domPosts);

			$pageId++;
		}

		// sorting by descending date and keeping only the $postCount first entries
		return Arrays::from($posts)
				->sort('date', 'desc')
				->first($postCount)
				->obtain();
	}
}

?>
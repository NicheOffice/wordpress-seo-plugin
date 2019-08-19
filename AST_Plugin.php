<?php
function create_seo_tags()
{
	global $post;
	if (!is_single())
	{
		return;
	}
	$meta         = strip_tags($post->post_content);
	$meta         = strip_shortcodes($post->post_content);
	$meta         = str_replace(array(
		"\n",
		"\r",
		"\t"
	), ' ', $meta);
	$meta         = substr($meta, 0, 125);
	$meta         = strip_tags($meta);
	$meta 		  = filter_var($meta, FILTER_SANITIZE_STRING);
	$title        = strip_tags($post->post_title);
	$title = filter_var($title, FILTER_SANITIZE_STRING);
	$image        = get_the_post_thumbnail_url();
	$link         = get_post_permalink();
	$authorName   = get_option('AST_Plugin_AuthorName');
	$siteName     = get_option('blogname');
	$facebookPage = get_option('AST_Plugin_FacebookURL');
	$twitterName  = get_option('AST_Plugin_TwitterName');
	echo "<meta name='seo-plugin' content='https://goo.gl/0Rr12h' />";
	echo "<meta name='description' content='$meta' />";
	echo "<meta property='og:description' content='$meta' />";
	echo "<meta name='author' content='$authorName' />";
	echo "<meta name='twitter:card' content='summary_large_image' />";
	echo "<meta name='twitter:site' content='@.$twitterName' />";
	echo "<meta name='twitter:creator' content='$twitterName' />";
	echo "<meta property='twitter:title' content='$title' />";
	echo "<meta name='twitter:description' content='$meta' />";
	echo "<meta name='twitter:image:src' content='$image' />";
	echo "<meta property='og:url' content='$link' />";
	echo "<meta property='og:type' content='article' />";
	echo "<meta property='og:title' content='$title' />";
	echo "<meta property='og:image' content='$image' />";
	echo "<meta property='og:description' content='$meta' />";
	echo "<meta property='og:site_name' content='$siteName' />";
	echo "<meta property='article:author' content='$facebookPage' />";
	echo "<meta property='article:publisher' content='$facebookPage' />";
}
add_action('wp_head', 'create_seo_tags');
$jpgQuality = get_option('AST_Plugin_JPGQuality');
add_filter('jpeg_quality', 'smashing_jpeg_quality');
function smashing_jpeg_quality()
{
	return $jpgQuality;
}
include_once('AST_LifeCycle.php');
class AST_Plugin extends AST_LifeCycle
{
	public function getOptionMetaData()
	{
		return array(
			'AuthorName' => array(
				__('Enter in your author name', 'my-awesome-plugin1')
			),
			'FacebookURL' => array(
				__('Enter in your Facebook page URL', 'my-awesome-plugin2')
			),
			'TwitterName' => array(
				__('Enter in your Twitter username without @', 'my-awesome-plugin3')
			),
			'JPGQuality' => array(
				__('JPEG Compression Rate (Default: 50)', 'my-awesome-plugin4')
			),
			'CanDoSomething' => array(
				__('Which user role can change plugin settings?', 'my-awesome-plugin5'),
				'Administrator',
				'Editor',
				'Author',
				'Contributor',
				'Subscriber',
				'Anyone'
			)
		);
	}
	protected function initOptions()
	{
		$options = $this->getOptionMetaData();
		if (!empty($options))
		{
			foreach ($options as $key => $arr)
			{
				if (is_array($arr) && count($arr > 1))
				{
					$this->addOption($key, $arr[1]);
				}
			}
		}
	}
	public function getPluginDisplayName()
	{
		return 'Automatic SEO Tags';
	}
	protected function getMainPluginFileName()
	{
		return 'automatic-seo-tags.php';
	}
	protected function installDatabaseTables()
	{
	}
	protected function unInstallDatabaseTables()
	{
	}
	public function upgrade()
	{
	}
	public function addActionsAndFilters()
	{
		add_action('admin_menu', array(
			&$this,
			'addSettingsSubMenuPage'
		));
	}
}
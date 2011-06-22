<?php
namespace app\controllers;


class FlickrExamplesController extends \lithium\action\Controller {
	
	protected $_classes = array(
		'media'			=> 'lithium\net\http\Media',
		'router'		=> 'lithium\net\http\Router',
		'response' 		=> 'lithium\action\Response',
		'connections'	=> 'lithium\data\Connections',
		'flickr' 		=> 'li3_flickr\extensions\adapter\data\source\http\Flickr'
	);
	protected $userId;

	public function index($username = false) {
		
		try {
			$flickr = \lithium\data\Connections::get('flickr');	
		} catch (\lithium\core\ConfigException $flickrDebugVars) {
			return $this->set(compact('flickrDebugVars'));
		}
		
		$username = !$username ? 'JacopKane' : $username;
		$flickrDebugVars = $flickr ? array(
				
			'flickr.test.echo' => $flickr->test_echo() ? $flickr->connection->last->response : 'fail',

			'this->userId' => $this->userId = isset($flickr->people_findByUsername(array(
				'username' => $username
			))->user->nsid) ? $flickr->connection->last->response->user->nsid : false,

			'flickr.test.login'	=> $flickr->test_login() ? $flickr->connection->last->response : 'fail',
			
			'permission.default' => $flickr->checkPermission('default') ? 'pass' : 'fail',
			
			'permission.read' => $flickr->checkPermission('read') ? 'pass' : $this->redirect($flickr->getAuthUrl('read')),

			'permission.write' => $flickr->checkPermission('write') ? 'pass' : 'fail',

			'permission.delete' => $flickr->checkPermission('delete') ? 'pass' : 'fail',

			'flickr.people.getPhotos me' => (
				isset($flickr->people_getPhotos(array(
					'user_id' => 'me'
				))->photos->photo) ? $flickr->connection->last->response->photos->photo : 'fail'
			),

			'photoDomain' => $this->photoTest = empty($flickr->connection->last->response->photos->photo) ? false : (
				$flickr->getDomain(array(
					'id'		=> 5723127353,
		            'secret'	=> 9634646433,
		            'server' 	=> 5172,
		            'farm'		=> 6,
		            'size'		=> 'b',
		            'extension'	=> 'jpg'
				), 'photo')
			),

			'photoTest' => $this->photoTest === false ? 'no photos found' : (
				"<img src=\"{$this->photoTest}\" />"
			),

			'flickr.people.getInfo' => $flickr->people_getInfo(array(
				'user_id' => $this->userId
			)) ? $flickr->connection->last->response : 'fail',

			'flickr.favorites.getList' => $flickr->favorites_getList() ? $flickr->connection->last->response : 'fail',

			'api' => array_map(function($method) {
				return $method->_content;
			}, isset($flickr->reflection_getMethods()->methods->method) ? $flickr->reflection_getMethods()->methods->method : array()),

			'cached_methods' => \lithium\storage\Cache::read('default', 'li3_flickr_methods')

		): 'no connection';

		$this->set(compact('flickrDebugVars'));
	}
}
?>

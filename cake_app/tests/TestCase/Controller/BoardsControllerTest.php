<?php
namespace App\Test\TestCase\Controller;

use App\Controller\BoardsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class BoardsControllerTest extends TestCase {
    use IntegrationTestTrait;

	public $fixtures = [
		'app.boards',
		'app.people'
	];

	public function testIndex() :void{
		$this->get('/boards');
		$this->assertResponseOk();
	}

	public function testShow() {
		$this->get('/boards/show/1');
		$this->assertResponseOk();
	}

	public function testAddPost(){
		$data = [
			'name' => 'test name 1',
			'password' => 'test password 1',
			'title' => 'test new title 1',
			'content' => 'test new content 1'
		];
		$this->post('/boards/add', $data);

		$this->assertResponseSuccess();
		$boards = TableRegistry::getTableLocator()->get('Boards');
		$query = $boards->find()->where(['title' => $data['title']]);
		$this->assertEquals(1, $query->count());
	}
}

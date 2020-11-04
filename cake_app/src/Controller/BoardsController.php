<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
/**
 * Boards Controller
 *
 * @property \App\Model\Table\BoardsTable $Boards
 * @method \App\Model\Entity\Board[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BoardsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    private $people;

    public function initialize(): void{
		parent::initialize();
		$this->people = TableRegistry::getTableLocator()->get('People');
    }

    public function index(){
        $data = $this->Boards
            ->find('all')
            ->order(['Boards.id' => 'DESC'])
			->contain(['People']);
		$this->set('data',$data);
    }
}

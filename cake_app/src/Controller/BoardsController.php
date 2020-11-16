<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\I18n\I18n;
use Cake\Event\EventInterface;
/**
 * Boards Controller
 *
 * @property \App\Model\Table\BoardsTable $Boards
 * @method \App\Model\Entity\Board[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BoardsController extends AppController
{
    private $people;
    public $paginate = [
      'limit' => 5,
      'order' => [
        'id' => 'DESC'
      ],
      'contain' => ['People']
    ];

    public function initialize(): void{
		parent::initialize();
    $this->people = TableRegistry::getTableLocator()->get('People');
    I18n::setLocale('ja_JP');
    $this->loadComponent('Paginator');
    $this->viewBuilder()->setLayout('boards');
    }

    public function index(){
        $data = $this->paginate($this->Boards);
        $this->set('data',$data);
        $this->set('count',$data->count());
    }

    public function add(){
      if ($this->request->is('post')){
        if (!$this->people->checkNameAndPass($this->request->getData())){
          $this->Flash->error('名前かパスワードを確認ください。');
        } else {
          $res = $this->people->find()
            ->where(['name'=>$this->request->getData('name')])
            ->andWhere(['password'=>$this->request->getData('password')])
            ->first();
          $board = $this->Boards->newEmptyEntity();
          $board->name = $this->request->getData('name');
          $board->title = $this->request->getData('title');
          $board->content = $this->request->getData('content');
          $board->person_id = $res['id'];
          if($this->Boards->save($board)){
            $this->redirect(['action' => 'index']);
          }
        }
      }
      $this->set('entity', $this->Boards->newEmptyEntity());
    }

    public function show($param = 0){
      $data = $this->Boards
        ->find()
        ->where(['Boards.id'=>$param])
        ->contain(['People'])
        ->first();
      $this->set('data',$data);
    }
    
    public function show2($param = 0){
      $data = $this->people->get($param);
      $this->set('data',$data);
    }

    public function edit($param=0){
      if ($this->request->is('put')){
        $board = $this->Boards
          ->find()
          ->where(['Boards.id'=>$param])
          ->contain(['People'])
          ->first();
        $board->title = $this->request->getData('title');
        $board->content = $this->request->getData('content');
        $board->person_id = $this->request->getData('person_id');
        if (!$this->people->checkNameAndPass($this->request->getData())){
          $this->Flash->error('名前かパスワードを確認ください。');
        } else {
          if($this->Boards->save($board)){
            $this->redirect(['action' => 'index']);
          }
        }
      } else {
        $board = $this->Boards
          ->find()
          ->where(['Boards.id'=>$param])
          ->contain(['People'])
          ->first();
      }
      $this->set('entity',$board);
    }

    public function beforeFilter(EventInterface $event) {
      parent::beforeFilter($event);
      $this->Auth->allow(['index']);
  }

    public function isAuthorized($user = null){
      $action = $this->request->getParam('action');

      if (in_array($action, ['index','view'])){
          return true;
      }
      if($user['role'] === 'admin'){
         return true;
      }
      if($user['role'] === 'user'){
         return true;
      }
      return false;
  }
}

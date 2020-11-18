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
    private $users;
    public $paginate = [
      'limit' => 5,
      'order' => [
        'id' => 'DESC'
      ],
      'contain' => ['Users']
    ];

    public function initialize(): void{
		parent::initialize();
    $this->users = TableRegistry::getTableLocator()->get('Users');
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
        $user = $this->Auth->identify();
        if(!empty($user)){
            $res = $this->Auth->user('id');
            $board = $this->Boards->newEmptyEntity();
            $board->name = $this->request->getData('username');
            $board->title = $this->request->getData('title');
            $board->content = $this->request->getData('content');
            $board->user_id = $res;
            if($this->Boards->save($board)){
              $this->redirect(['action' => 'index']);
            }
        } else {
          $this->Flash->error('名前かパスワードを確認ください。');
        }
      }
      $this->set('entity', $this->Boards->newEmptyEntity());
    }

    public function show($param = 0){
      $data = $this->Boards
        ->find()
        ->where(['Boards.id'=>$param])
        ->contain(['Users'])
        ->first();
      $this->set('data',$data);
    }

    public function show2($param = 0){
      $data = $this->users->get($param);
      $this->set('data',$data);
    }

    public function edit($param=0){
      if ($this->request->is('put')){
        $board = $this->Boards
          ->find()
          ->where(['Boards.id'=>$param])
          ->contain(['Users'])
          ->first();
        $board->title = $this->request->getData('title');
        $board->content = $this->request->getData('content');
        $board->user_id = $this->request->getData('user_id');

        $user = $this->Auth->identify();
        if(!empty($user)){
          if($this->Boards->save($board)){
            $this->redirect(['action' => 'index']);
        }
       } else {
          $this->Flash->error('名前かパスワードを確認ください。');
          }
      } else {
        $board = $this->Boards
          ->find()
          ->where(['Boards.id'=>$param])
          ->contain(['Users'])
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

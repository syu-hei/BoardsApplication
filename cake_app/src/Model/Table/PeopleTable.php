<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PeopleTable extends Table {

public function initialize(array $config): void{
	$this->hasMany('Boards');
}

	public function validationDefault(Validator $validator): Validator{
		$validator
			->integer('id');
		$validator
			->notEmptyString('name','必須項目です。');
		$validator
			->notEmptyString('password','必須項目です。');
		$validator
			->notEmptyString('comment','必須項目です。');
		
		return $validator;
	}
	
	public function buildRules(RulesChecker $rules): RulesChecker{
		$rules->isUnique(['name'],'既に登録済みです。');
		return $rules;
    }
    
    public function checkNameAndPass($data){
		$n = $this->find()
			->where(['name'=>$data['name']])
			->andWhere(['password'=>$data['password']])
			->count();
		return $n > 0 ? true : false;
	}

}
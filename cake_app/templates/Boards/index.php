<h1><?=__('board') ?></h1>
<p><a href="/boards/add"><?=__('post') ?></a></p>
<p><?=__('{0} post',$count) ?></p>
<div>
<table>
<tr>
	<th><?=$this->Paginator->sort('id','投稿順') ?></th>
	<th><?=$this->Paginator->sort('Person.name','名前') ?></th>
	<th><?=$this->Paginator->sort('title','タイトル') ?></th>
</tr>

<?php foreach ($data as $obj): ?>
<tr>
	<td><?=$obj['id']?></td>

	<td style='color:#000066; background-color: #CCCCFF'><?=$this->Html->link(
		$obj['person']['name'],
		['action' => 'show2',$obj['person_id']]
	) ?></td>


	<td style='color:#006600; background-color: #EEFFEE'><?=$this->Html->link(
		$obj['title'],
		['action' => 'show',$obj['id']]
	) ?></td>
</tr>
<?php endforeach; ?>
</table>
<div class="paginator">
	<ul class="pagination">
		<?=$this->Paginator->numbers([
			'before'=>$this->Paginator->hasPrev() ? 
				$this->Paginator->first('<<') . '・' : '',
			'after'=>$this->Paginator->hasNext() ? 
				'・' . $this->Paginator->last('>>') : '',
			'modulus'=>4,
			'separator'=>'・'
		]) ?>
	</ul>
</div>
</div>
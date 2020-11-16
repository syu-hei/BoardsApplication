<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Board $nextBoard
 */
?>

<h1>投稿フォーム</h1>
<p><?=$this->Html->link(
    '※一覧に戻る',
    ['action' => 'index']
) ?></p>
<?=$this->Form->create($entity) ?>
<fieldset>
	<div class="error"><?=$this->Form->error('name') ?></div>
	名前 : <?=$this->Form->input('name',['type'=>'text']) ?>
	<div class="error"><?=$this->Form->error('password') ?></div>
	パスワード : <?=$this->Form->input('password',['type'=>'password']) ?>
	<div class="error"><?=$this->Form->error('title') ?></div>
	タイトル : <?=$this->Form->input('title',['type'=>'text']) ?>
	<div class="error"><?=$this->Form->error('content') ?></div>
	内容 : <?=$this->Form->textarea("content") ?>
</fieldset>
<?=$this->Form->button("送信") ?>
<?=$this->Form->end() ?>
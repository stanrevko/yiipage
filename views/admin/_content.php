<?
Yii::app()->clientScript->registerScriptFile('/libs/redactorjs/ru.js');
Yii::app()->clientScript->registerScriptFile('/libs/django-urlify/urlify.js');
Yii::app()->clientScript->registerScript('translit', "
$('#translit-btn').click(function() {
	$('#Page_slug').val($('#Page_page_title').val().translit().toLowerCase());
});
");
?>

<?= $form->dropDownListRow($model, 'parent_id', $model->selectList(), array('class' => 'span6', 'empty' => '')) ?>

<?= $form->textFieldRow($model, 'page_title', array('class' => 'span6', 'maxlength' => 255)) ?>

<div class="control-group">
	<?= $form->labelEx($model, 'slug', array('class' => 'control-label', 'label' => 'Псевдоним')) ?>
	<div class="controls">
		<div class="input-append">
			<?= $form->textField($model, 'slug', array('class' => 'span5', 'maxlength' => 127)) ?><button class="btn" type="button" id="translit-btn">Транслит</button>
		</div>
	</div>
</div>

<?= $form->checkBoxRow($model, 'is_published') ?>

<?= $form->dropDownListRow($model, 'template', $templates, array('class' => 'span3')) ?>

Для розриву сторінки вставити: <? echo CHtml::encode('<p class="break"></p>')?>
<br/>
<div class="control-group">
	<?= $form->labelEx($model, 'content', array('class' => 'control-label')) ?>
	<div class="controls">
		<? $this->widget('core.extensions.imperavi-redactor.ImperaviRedactorWidget', array(
			'model' => $model,
			'attribute' => 'content',
			'options' => array(
				'lang' => 'ru',
			),
		)) ?>
	</div>
</div>

<script>
    
     String.prototype.translit = (function(){ 
    var L = {
'А':'A','а':'a','Б':'B','б':'b','В':'V','в':'v','Г':'G','г':'g',
'Д':'D','д':'d','Е':'E','е':'e','Ё':'Yo','ё':'yo','Ж':'Zh','ж':'zh',
'З':'Z','з':'z','И':'I','и':'i','Й':'Y','й':'y','К':'K','к':'k',
'Л':'L','л':'l','М':'M','м':'m','Н':'N','н':'n','О':'O','о':'o',
'П':'P','п':'p','Р':'R','р':'r','С':'S','с':'s','Т':'T','т':'t',
'У':'U','у':'u','Ф':'F','ф':'f','Х':'Kh','х':'kh','Ц':'Ts','ц':'ts',
'Ч':'Ch','ч':'ch','Ш':'Sh','ш':'sh','Щ':'Sch','щ':'sch','Ъ':'"','ъ':'"',
'Ы':'Y','ы':'y','Ь':"'",'ь':"'",'Э':'E','э':'e','Ю':'Yu','ю':'yu',
'Я':'Ya','я':'ya', ' ': '_', 'і':'i', 'ї': 'i',
        },
        r = '',
        k;
    for (k in L) r += k;
    r = new RegExp('[' + r + ']', 'g');
    k = function(a){
        return a in L ? L[a] : '';
    };
    return function(){
        return this.replace(r, k);
    };
})();
    </script>
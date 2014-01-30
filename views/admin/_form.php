<?
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'page-form',
    'inlineErrors' => false,
    'type' => 'horizontal',
        ))
?>

<?= $form->errorSummary($model) ?>

<?
$this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'tabs',
    'tabs' => array(
        array(
            'label' => 'Страница',
            'content' => $this->renderPartial('_content', array('form' => $form, 'model' => $model,
                'templates' => $templates), true),
            'active' => true
        ),
        array(
            'label' => 'SEO',
            'content' => $this->renderPartial('_seo', array('form' => $form, 'model' => $model), true),
        ),
    ),
))
?>

<div class="form-actions">
    <?
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? 'Добавить' : 'Сохранить',
    ))
    ?>

    <?
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'button',
        'type' => 'primary',
        'id' => 'submitCreate',
        'label' => 'Сохранить и создать',
    ))
    ?>
<?
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'button',
    'type' => 'primary',
    'id' => 'submitCreate',
    'label' => 'Сохранить и закрыть',
))
?>
</div>

<? $this->endWidget() ?>

<!--<center><h1> <?= $page->page_title ?></h1></center> -->
<?= $page->content ?>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $page->searchChildren(),
    //  'dataProvider'=>new CActiveDataProvider('Page'),
    'itemView' => 'templates/_article', // refers to the partial view named '_post'
    'ajaxVar' => 'p',
    'ajaxUpdate'=>false,
    'template' => '{pager}{items}{pager}',
    //  'baseScriptUrl' => '',
    'summaryText' => '',
    'pager' => array(
        'pages' => array('pageVar' => 'p'),
        'htmlOptions' => array('class' => 'LinkPager'),
        'header' => '',
        //'class'			=> 'LinkPager',
        'firstPageLabel' => '',
        'firstPageCssClass' => 'hidden',
        'lastPageCssClass' => 'hidden',
        'prevPageLabel' => '<',
        'nextPageLabel' => '>',
        'lastPageLabel' => '>>|',
        'maxButtonCount' => '10',
        //'header'			=> 'Pages: ',
        'cssFile' => false,
    ),
));
?>

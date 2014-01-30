<?php
$this->pageTitle = $page->page_title;
$this->metaTitle = $page->meta_title;
$this->metaDescription = $page->meta_description;
$this->metaKeywords = $page->meta_keywords;
$this->breadcrumbs = $page->breadcrumbs;
//$this->layout = '//layouts/' . ($page->layout ? $page->layout : 'column1');
//var_dump($this->layout);

 
    
?>
<? // $page->preview 
$this->widget('zii.widgets.CBreadcrumbs', array(
    'links'=>$this->breadcrumbs
));
?>

<?php echo  $page->content ?>


<?php ?>
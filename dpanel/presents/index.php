<?php

include_once '../../sys/inc/start.php';
dpanel::check_access();

$doc = new document(4);
$doc->title = __('Подарки - Категории');

$pages = new pages();
$res = $db->query("SELECT COUNT(*) FROM `present_categories`");
$pages->posts = $res->fetchColumn();

$listing = new ui_components();
$listing->ui_segment = true; //подключаем css segments
$listing->class = 'ui segments';

$q = $db->query("SELECT * FROM `present_categories` ORDER BY `position` ASC LIMIT " . $pages->limit);

while ($category = $q->fetch()) {
    $post = $listing->post();
    $post->class = 'ui segment';
    $post->ui_label = true;
    $post->list = true;
    $post->url = "category.php?id=$category[id]";
    $post->title = text::toValue($category['name']);
    $post->icon('folder-o');
    $post->post = text::for_opis($category['description']);
    $resq = $db->query("SELECT COUNT(*) FROM  `present_items` WHERE `id_category` = '$category[id]'");
    $post->counter = $resq->fetchColumn();
}

$listing->display(__('Категорий нет'));
$pages->display('?');

$doc->opt(__('Создать категорию'), './category.new.php', false, '<i class="fa fa-plus fa-fw"></i>');

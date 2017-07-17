<div class="block">Здравствуйте, <?=$this->user['name']?>!</div>
<div class="block">
<?php
if ($pages) {
    ?>
    <div>Ваши страницы:</div>
    <table class="pages">
        <?php
        foreach ($pages as $page) {
        ?>
        <tr>
            <td class="first-cell"><a href='<?=$this->url('pages', 'view', [$page['id']])?>' class="page-link"><?=$page['title']?></a></td>
            <td><a href='<?=$this->url('pages', 'change', [$page['id']])?>' class="page-action">Изменить</a></td>
            <td><a href='<?=$this->url('pages', 'delete', [$page['id']])?>' class="page-action">Удалить</a></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
} else {
?>
<div>На данный момент у вас нет страниц.</div>
<?php
}
?>
</div>
<div class="block">
    <a href='<?=$this->url('pages', 'create')?>'>Добавить страницу</a>
    <a href='<?=$this->url('login', 'logout')?>'>Выйти</a>
</div>

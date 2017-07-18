<?php
if ($this->sessionData['searchResults'] !== null) {
    if (sizeof($this->sessionData['searchResults'])) {
    ?>
    <div>Результат поиска по значению <span class="italic"><?=$this->sessionData['searchValue']?></span>:</div>
    <table class="pages">
    <?php
    foreach ($this->sessionData['searchResults'] as $page) {
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
    <div class="block">По заданному значению <span class="italic"><?=$this->sessionData['searchValue']?></span> ничего не найдено.</div>
    <?php
    }
}
?>
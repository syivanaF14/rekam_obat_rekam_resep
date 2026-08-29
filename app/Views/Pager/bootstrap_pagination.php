<?php
use CodeIgniter\Pager\PagerRenderer;

/**
 * Pagination Bootstrap 5.
 *
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
$prevUrl = $pager->hasPrevious() ? $pager->getPrevious() : '#';
$nextUrl = $pager->hasNext() ? $pager->getNext() : '#';
?>
<nav aria-label="Pagination">
    <ul class="pagination pagination-sm mb-0">
        <li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $prevUrl ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach; ?>

        <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $nextUrl ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>

<?php $pager->setSurroundCount(2); ?>
<ul class="flex items-center space-x-2">
    <?php if ($pager->hasPrevious()) : ?>
        <li>
            <a href="<?= $pager->getFirst(); ?>" 
               class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200">
                First
            </a>
        </li>
        <li>
            <a href="<?= $pager->getPrevious(); ?>" 
               class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200">
                &laquo;
            </a>
        </li>
    <?php endif; ?>

    <?php foreach ($pager->links() as $link) : ?>
        <li>
            <a href="<?= $link['uri']; ?>" 
               class="px-3 py-1 <?= $link['active'] ? 'bg-blue-600 text-white' : 'border border-gray-300 hover:bg-gray-200'; ?> rounded">
                <?= $link['title']; ?>
            </a>
        </li>
    <?php endforeach; ?>

    <?php if ($pager->hasNext()) : ?>
        <li>
            <a href="<?= $pager->getNext(); ?>" 
               class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200">
                &raquo;
            </a>
        </li>
        <li>
            <a href="<?= $pager->getLast(); ?>" 
               class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200">
                Last
            </a>
        </li>
    <?php endif; ?>
</ul>

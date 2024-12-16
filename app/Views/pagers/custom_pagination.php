<?php $pager->setSurroundCount(2); ?>
<div class="flex items-center justify-center mt-4">
    <nav aria-label="Pagination">
        <ul class="inline-flex items-center -space-x-px">
            <!-- Tombol Previous -->
            <?php if ($pager->hasPrevious()) : ?>
                <li>
                    <a href="<?= $pager->getPrevious(); ?>" 
                       class="flex items-center justify-center px-4 py-2 rounded-l-lg border border-gray-300 bg-gray-200 text-gray-600 font-semibold hover:bg-gray-300 hover:text-yellow-600 focus:z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Nomor Halaman -->
            <?php foreach ($pager->links() as $link) : ?>
                <li>
                    <a href="<?= $link['uri']; ?>" 
                       class="flex items-center justify-center px-4 py-2 border border-gray-300 text-sm leading-5
                              <?= $link['active'] ? 'text-yellow-500 bg-gray-900 border-gray-900 hover:bg-gray-900' : 'bg-gray-200 text-gray-600 font-semibold hover:bg-gray-300 hover:text-yellow-600'; ?> focus:z-10">
                        <?= $link['title']; ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <!-- Tombol Next -->
            <?php if ($pager->hasNext()) : ?>
                <li>
                    <a href="<?= $pager->getNext(); ?>" 
                       class="flex items-center justify-center px-4 py-2 rounded-r-lg border border-gray-300 bg-gray-200 text-gray-600 font-semibold hover:bg-gray-300 hover:text-yellow-600 focus:z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

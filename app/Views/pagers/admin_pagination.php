<div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-center">
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <!-- Tombol Previous -->
            <?php if ($page > 1): ?>
                <a href="<?= $baseUrl . '?page=' . ($page - 1) . $queryParams ?>"
                   class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
                    <span class="sr-only">Previous</span>
                    &laquo;
                </a>
            <?php else: ?>
                <span class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-gray-100 px-2 py-2 text-sm font-medium text-gray-400">
                    &laquo;
                </span>
            <?php endif; ?>

            <!-- Link Halaman -->
            <?php
            function paginationLinks($currentPage, $totalPages)
            {
                $maxVisiblePages = 5;
                $pages = [];

                if ($totalPages <= $maxVisiblePages) {
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $pages[] = $i;
                    }
                } else {
                    $pages[] = 1;

                    $start = max(2, $currentPage - 1);
                    $end = min($totalPages - 1, $currentPage + 1);

                    if ($start > 2) {
                        $pages[] = '...';
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        $pages[] = $i;
                    }

                    if ($end < $totalPages - 1) {
                        $pages[] = '...';
                    }

                    $pages[] = $totalPages;
                }

                return $pages;
            }

            $paginationLinks = paginationLinks($page, $totalPages);

            foreach ($paginationLinks as $link): ?>
                <?php if ($link === '...'): ?>
                    <span class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500">...</span>
                <?php elseif ($link == $page): ?>
                    <span class="relative z-10 inline-flex items-center border border-blue-500 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-600"><?= $link ?></span>
                <?php else: ?>
                    <a href="<?= $baseUrl . '?page=' . $link . $queryParams ?>"
                       class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <?= $link ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>

            <!-- Tombol Next -->
            <?php if ($page < $totalPages): ?>
                <a href="<?= $baseUrl . '?page=' . ($page + 1) . $queryParams ?>"
                   class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
                    <span class="sr-only">Next</span>
                    &raquo;
                </a>
            <?php else: ?>
                <span class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-gray-100 px-2 py-2 text-sm font-medium text-gray-400">
                    &raquo;
                </span>
            <?php endif; ?>
        </nav>
    </div>
</div>

{if $totalPages > 1}
    <nav class="pagination" aria-label="Pagination">
        {if $page > 1}
            <a href="/category?id={$category.id|escape}&sort={$sort|escape}&page={$page - 1}&per_page={$perPage|escape}">
                Previous
            </a>
        {/if}

        {for $pageNumber=1 to $totalPages}
            {if $pageNumber == $page}
                <span aria-current="page">{$pageNumber}</span>
            {else}
                <a href="/category?id={$category.id|escape}&sort={$sort|escape}&page={$pageNumber}&per_page={$perPage|escape}">
                    {$pageNumber}
                </a>
            {/if}
        {/for}

        {if $page < $totalPages}
            <a href="/category?id={$category.id|escape}&sort={$sort|escape}&page={$page + 1}&per_page={$perPage|escape}">
                Next
            </a>
        {/if}
    </nav>
{/if}
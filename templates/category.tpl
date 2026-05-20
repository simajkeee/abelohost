{extends file="layouts/main.tpl"}

{block name="title"}Category: {$category.title|escape} | AbeloHost Blog{/block}

{block name="content"}
<section class="category-header">
    <h1>{$category.title|escape}</h1>

    {if $category.description}
        <p>{$category.description|escape}</p>
    {/if}
</section>

<section class="category-articles">
    <div class="category-articles__header">
        <h2>Articles</h2>

        <nav class="category-sort" aria-label="Article sorting">
            <a href="/category?id={$category.id|escape}&sort=date&page=1&per_page={$perPage|escape}"
               {if $sort === 'date'}aria-current="true"{/if}>
                Newest
            </a>

            <a href="/category?id={$category.id|escape}&sort=views&page=1&per_page={$perPage|escape}"
               {if $sort === 'views'}aria-current="true"{/if}>
                Most viewed
            </a>
        </nav>
    </div>

    {if $articles}
        <div class="article-grid">
            {foreach $articles as $article}
                {include file="partials/article-card.tpl" article=$article}
            {/foreach}
        </div>

        {include file="partials/paginations.tpl"
        category=$category
        page=$page
        perPage=$perPage
        totalPages=$totalPages
        sort=$sort
        }
    {else}
        <p>No articles found in this category.</p>
    {/if}
</section>
{/block}

{extends file="layouts/main.tpl"}

{block name="title"}Home | AbeloHost Blog{/block}

{block name="content"}
<h1>Blog</h1>

{if $categoriesWithArticles}
    {foreach $categoriesWithArticles as $category}
        <section class="home-category">
            <div class="home-category__header">
                <div>
                    <h2>{$category.title|escape}</h2>

                    {if $category.description}
                        <p>{$category.description|escape}</p>
                    {/if}
                </div>

                <a href="/category?id={$category.id|escape}" class="home-category__all-link">
                    All Articles
                </a>
            </div>

            {if $category.articles}
                <div class="article-grid">
                    {foreach $category.articles as $article}
                        {include file="partials/article-card.tpl" article=$article}
                    {/foreach}
                </div>
            {else}
                <p>No articles found in this category.</p>
            {/if}
        </section>
    {/foreach}
    {else}
        <p>No articles found.</p>
    {/if}
{/block}
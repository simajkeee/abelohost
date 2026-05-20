{extends file="layouts/main.tpl"}

{block name="title"}Article: {$article.title|escape} | AbeloHost Blog{/block}

{block name="content"}
<article class="article-page">
    {if $article.image}
        <img
            src="/assets/{$article.image|escape}"
            alt="{$article.title|escape}"
            class="article-page__image"
        >
    {/if}

    <header class="article-page__header">
        <h1>{$article.title|escape}</h1>

        {if $article.description}
            <p>{$article.description|escape}</p>
        {/if}

        <div class="article-page__meta">
            {if $article.published_at}
                <time datetime="{$article.published_at|escape}">
                    Published at: {$article.published_at|date_format:"%b %e, %Y"}
                </time>
            {/if}

            <span>{$article.view_count|escape} views</span>
        </div>
        {if $categories}
            <nav class="article-page__categories" aria-label="Article categories">
                {foreach $categories as $category}
                    <a href="/category?id={$category.id|escape}">
                        {$category.title|escape}
                    </a>
                {/foreach}
            </nav>
        {/if}
    </header>

    <div class="article-page__content">
        {$article.content|escape|nl2br nofilter}
    </div>
</article>

    <section class="related-articles">
        <h2>Related articles</h2>

        {if $relatedArticles}
            <div class="article-grid">
                {foreach $relatedArticles as $article}
                    {include file="partials/article-card.tpl" article=$article}
                {/foreach}
            </div>
        {else}
            <p>No related articles found.</p>
        {/if}
    </section>
{/block}
<article class="article-card">
    {if $article.image}
        <a href="/article?id={$article.id|escape}" class="article-card__image-link">
            <img
                src="/assets/{$article.image|escape}"
                alt="{$article.title|escape}"
                class="article-card__image"
            >
        </a>
    {/if}

    <div class="article-card__body">
        <h3 class="article-card__title">
            <a href="/article?id={$article.id|escape}">
                {$article.title|escape}
            </a>
        </h3>

        {if $article.description}
            <p class="article-card__description">
                {$article.description|escape}
            </p>
        {/if}

        <div class="article-card__meta">
            {if $article.published_at}
                <div>
                    <time datetime="{$article.published_at|escape}">
                        Published at: {$article.published_at|date_format:"%b %e, %Y"}
                    </time>
                </div>
            {/if}

            {if $article.created_at}
                <div>
                    <time datetime="{$article.created_at|escape}">
                        Created at: {$article.created_at|date_format:"%b %e, %Y"}
                    </time>
                </div>
            {/if}

            <span>{$article.view_count|escape} views</span>
        </div>
    </div>
</article>
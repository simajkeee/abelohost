{extends file="layouts/main.tpl"}

{block name="title"}Home | AbeloHost Blog{/block}

{block name="content"}
    <h1>Latest articles</h1>

    {foreach $latestArticles as $article}
        <article>
            <h2>{$article.title|escape}</h2>
            <p>{$article.description|escape}</p>
        </article>
    {/foreach}
{/block}
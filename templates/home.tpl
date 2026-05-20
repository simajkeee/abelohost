<h1>Blog</h1>

<h2>Latest articles</h2>

{foreach $latestArticles as $article}
    <article>
        <h3>{$article.title|escape}</h3>
        <p>{$article.description|escape}</p>
    </article>
{/foreach}
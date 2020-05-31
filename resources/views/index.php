<div id="main__index" class="uk-container">
    <ul class="uk-list">
        <?php foreach ($posts as $post) : ?>
        <li>
            <article class="uk-article">
            <h1 class="uk-article-title">
                <a href="/posts/<?=$post->id?>" class="uk-link-reset"><?=$post->title?></a>
            </h1>
            <div class="uk-text-meta">by <?=$post->getUsername()?></div>
            <p class="uk-margin"><?=$post->getSummary()?></p>
            <div class="uk-text-meta"><?=$post->getCreatedAt()?></div>
            </article>
            <hr />
        </li>
        <?php endforeach; ?>
    </ul>
</div>
<button id="readmore" class="uk-button uk-button-default">Read more</button>

<script>
    const $readmore = document.getElementById('readmore')
    if ($readmore instanceof HTMLElement) {
        let page = 0
        $readmore.addEventListener('click', () => fetch('/?page=' + ++page, { method: 'get' }).then(async response => {
            const parser = new DOMParser()
            const doc = parser.parseFromString(await response.text(), 'text/html')
            const list = doc.querySelectorAll('.uk-container > .uk-list > li')
            if (list.length > 0) {
                Array.from(list).forEach(item => {
                    document.querySelector('.uk-container > .uk-list').appendChild(item)
                })
            }
        }))
    }
</script>

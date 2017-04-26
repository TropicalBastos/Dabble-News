<?php include "templates/include/header.php"; ?>

<ul id="headlines">

<?php foreach($results["articles"] as $article):?>

<div class="article-div">
  <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id;?>">
    <li class="article">
    <div class="pubDate">Published on <?php echo date('j F Y',$article->publicationDate);?></div>
    <h1><?php echo $article->title?></h1>
    <p class="summary"><?php echo htmlspecialchars($article->summary);?></p>
    </li>
  </a>
</div>

<?php endforeach;?>

</ul>

<div class="button"><a href="./?action=archive">All Articles</a></div>

<?php include "templates/include/footer.php"; ?>

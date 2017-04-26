<?php include "templates/include/header.php";?>

<h1>Article Archive</h1>

<ul id="headlines" class="archive">

  <?php foreach($results["articles"] as $article):?>
    <li class="article-div">
    <a href=".?action=viewArticle&amp;articleId=<?php echo $article->id;?>">
      <span class="pubDate"><?php echo date('j F Y',$article->publicationDate);?></span>
      <h1><?php echo $article->title?></h1>
      <p class="summary"><?php echo htmlspecialchars($article->summary);?></p>
    </a>
  </li class="article-div">
  <?php endforeach;?>

</ul>

<p><?php echo $results['totalRows']?> article<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>

<div class="button"><a href="./">Return to Homepage</a></div>

<?php include "templates/include/footer.php";?>

<?php include "templates/include/header.php"; ?>

<div id="adminHeader">
  <h3>You are now logged in as <?php echo htmlspecialchars($_SESSION["username"])?></h3>
</div>
<p class="errorMessage">
<?php
if(isset($results["errorMessage"])){
  echo $results["errorMessage"];
}
?>
</p>

<h1>All Articles</h1>

<p>
<?php
if(isset($results["status"])){
  echo $results["status"];
}
?>
</p>

<ul>
<?php foreach($results["articles"] as $article):?>
    <li class="article-div">
      <h1><?php echo htmlspecialchars($article->title);?></h1>
      <p>Published on <?php echo date("j F Y",$article->publicationDate)?></p>
      <span>
        <a class="button" href="admin.php?action=editArticle&amp;articleId=<?php echo $article->id;?>">Edit</a>
        <a class="button" href="admin.php?action=deleteArticle&amp;articleId=<?php echo $article->id;?>">Delete</a>
      </span>
    </li>
  <?php endforeach; ?>
</ul>

<a class="button" href="admin.php?action=newArticle">Add a new article</a>
<a href="admin.php?action=logout"><span class="button">Log out</span></a>
<?php include "templates/include/footer.php" ?>

<?php include "templates/include/header.php" ?>

<div class="article-container">
  <div class="publication">Published on <?php echo date('j F Y',$results["article"]->publicationDate);?></div>
  <h1 class="articleTitle"><?php echo $results["pageTitle"];?></h1>
  <p class="summary"><?php echo nl2br($results["article"]->summary);?>
  <p class="content"><?php echo nl2br($results["article"]->content);?></p>
</div>

<?php include "templates/include/footer.php"; ?>

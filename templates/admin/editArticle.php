<?php include "templates/include/header.php"; ?>

<h2><?php echo $results["pageTitle"];?></h2>

<div class="article-div">
<form action="admin.php?action=<?php echo $results['formAction'];?>" method="post">

  <input type="hidden" name="articleId" value="<?php echo $results['article']->id;?>">
  <h3>Title:</h3>
  <input id="articleTitle" name="title" value="<?php echo htmlspecialchars($results['article']->title);?>">

  <h3>Summary:</h3>
  <textarea id="articleSummary" name="summary"><?php echo htmlspecialchars($results["article"]->summary);?></textarea>

  <h3>Content:</h3>
  <textarea id="articleContent" name="content"><?php echo htmlspecialchars($results["article"]->content);?></textarea>

<div class="submit-buttons">
  <button class="button" type="submit" name="saveChanges">Save Changes</button>
  <button class="button" type="submit" name="cancel">Cancel</button>
</div>
</div>
<?php if ($results["article"]->id):?>
  <a href="admin.php?action=deleteArticle&amp;articleId=<?php echo $results['article']->id;?>">Delete this Article</a>
<?php endif;?>

</form>

<?php include "templates/include/footer.php";?>

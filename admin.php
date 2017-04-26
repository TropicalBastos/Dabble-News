<?php

require("cms/config.php");
session_start();
$action = isset($_GET["action"]) ? $_GET["action"] : "";
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";

if ($action != "login" && $action != "logout" && !$username){
  login();
  exit;
}

switch($action){
  case "login":
    login();
    break;
  case "logout":
    logout();
    break;
  case "newArticle":
    newArticle();
    break;
  case "editArticle":
    editArticle();
    break;
  case "deleteArticle":
    deleteArticle();
    break;
  default:
    listArticles();
    break;
}

function login(){
  $results = array();
  $results["pageTitle"] = "Admin Login";

  if(isset($_POST["login"])){
    //user has attempted to login
    if($_POST["username"]==ADMIN_USER && $_POST["password"]==ADMIN_PASS){
      //successful
      $_SESSION["username"] = ADMIN_USER;
      header("Location: admin.php");
    }else{
      $results["errorMessage"] = "Incorrect username or password. Please try again.";
      require(TEMPLATE_PATH . "/admin/loginForm.php");
    }
  }else{
    require(TEMPLATE_PATH . "/admin/loginForm.php");
  }
}

function logout(){
  unset($_SESSION["username"]);
  header("Location: admin.php");
}

function newArticle(){
  $results = array();
  $results["pageTitle"] = "New Article";
  $results["formAction"] = "newArticle";

  if(isset($_POST["saveChanges"])){
    //User has posted the article edit form save the new one
    $article = new Article;
    $article->storeFormValues($_POST);
    $article->insert();
    header("Location: admin.php?status=changesSaved");
  }elseif(isset($_POST["cancel"])){
    //User has cancelled edits
    header("Location: admin.php");
  }else{
    //user has not posted the article edit form yet, display the form
    $results["article"] = new Article;
    require(TEMPLATE_PATH . "/admin/editArticle.php");
  }
}

function editArticle(){
  $results = array();
  $results["pageTitle"] = "Edit Article";
  $results["formAction"] = "editArticle";

  if(isset($_POST["saveChanges"])){
    //User posted article edit form save changes
    if(!$article = Article::getArticleById((int) $_POST["articleId"])){
      header("Location: admin.php?error=articleNotFound");
      return;
    }

    $article->storeFormValues($_POST);
    $article->update();
    header("Location: admin.php?status=changesSaved");
  }elseif(isset($_POST["cancel"])){
    header("Location: admin.php");
  }else{
    $results["article"] = Article::getArticleById((int) $_GET["articleId"]);
    require(TEMPLATE_PATH . "/admin/editArticle.php");
  }
}

function deleteArticle(){
  if(!$article = Article::getArticleById((int) $_GET["articleId"])){
    header("Location: admin.php?error=articleNotFound");
    return;
  }

  $article->delete();
  header("Location: admin.php?status=articleDeleted");
}

function listArticles(){
  $results = array();
  $data = Article::getList();
  $results["articles"] = $data["results"];
  $results["pageTitle"] = "All Articles";
  $results["totalRows"] = $data["totalRows"];

  if(isset($_GET["error"])){
    if($_GET["error"]=="articleNotFound"){
      $results["errorMessage"] = "Error: Article not found!";
    }
  }

  if(isset($_GET["status"])){
    if($_GET["status"]=="changesSaved"){
      $results["status"] = "Changes saved!";
    }
    if($_GET["status"]=="articleDeleted"){
      $results["status"] = "Article deleted.";
    }
  }

  require(TEMPLATE_PATH . "/admin/listArticles.php");
}


 ?>

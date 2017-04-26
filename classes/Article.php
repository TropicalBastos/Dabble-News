<?php

class Article{

/*
Members
Check database schema at ./sqlSchema/articles.sql
*/
public $id = null;
public $publicationDate = null;
public $title = null;
public $summary = null;
public $content = null;

//Constructor
public function __construct($data = array()){
  if(isset($data['id'])) $this->id = (int) $data['id'];
  if(isset($data['publicationDate']))
    $this->publicationDate = (int) $data['publicationDate'];
  if(isset($data['title'])) $this->title = (string) $data['title'];
  if(isset($data['summary'])) $this->summary = $data['summary'];
  if(isset($data['content'])) $this->content = $data['content'];
}

public function storeFormValues($params){
  $this->__construct($params);

  if(isset($params['publicationDate'])){
    $publicationDate = explode("-",$params['publicationDate']);
    if(count($publicationDate)==3){
      list ($y,$m,$d) = $publicationDate;
      $this->publicationDate = mktime(0,0,0,$m,$d,$y);
    }
  }else{
    $this->publicationDate = time();
  }
}

/*
Return wrapped article object from database
@params int: the id of the article
*/

public static function getArticleById($id){
  $connection = new PDO(DB,DB_USER,DB_PASS);
  $sqlQuery = "SELECT *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM articles WHERE id=:id";
  $statement = $connection->prepare($sqlQuery);
  $statement->bindValue(":id",$id,PDO::PARAM_INT);
  $statement->execute();
  $row = $statement->fetch(PDO::FETCH_ASSOC);
  $connection = null;
  if($row) return new Article($row);
}

/*
Fetch a list of article wrapped objects from database
@param int: limit to the number of rows
@param string: sql string that orders the returned list
*/

public static function getList($numRows = 1000000,$order = "publicationDate DESC"){
  $connection = new PDO(DB,DB_USER,DB_PASS);
  $sqlQuery = "SELECT SQL_CALC_FOUND_ROWS *,UNIX_TIMESTAMP(publicationDate) AS publicationDate
   FROM articles ORDER BY " . mysql_escape_string($order) .
   " LIMIT :numRows";
  $statement = $connection->prepare($sqlQuery);
  $statement->bindValue(":numRows",$numRows,PDO::PARAM_INT);
  $statement->execute();
  $list = array();

  //get every article fetched by statement and create object for each row
  while($row = $statement->fetch(PDO::FETCH_ASSOC)){
    $article = new Article($row);
    //push article to list array
    $list[] = $article;
  }

  //Now get the total number of articles that matched
  $sql = "SELECT FOUND_ROWS() AS totalRows";
  $result = $connection->query($sql)->fetch();
  $connection = null;
  return array("results"=>$list,"totalRows"=>$result[0]);
}

//insert article object into database
public function insert(){
  $connection = new PDO(DB,DB_USER,DB_PASS);
  $sqlQuery = "INSERT INTO articles ( publicationDate, title, summary, content)
  VALUES ( FROM_UNIXTIME(:publicationDate), :title, :summary, :content)";
  $statement = $connection->prepare($sqlQuery);
  $statement->bindValue(":publicationDate",$this->publicationDate,PDO::PARAM_INT);
  $statement->bindValue(":title",$this->title,PDO::PARAM_STR);
  $statement->bindValue(":summary",$this->summary,PDO::PARAM_STR);
  $statement->bindValue(":content",$this->content,PDO::PARAM_STR);
  $statement->execute();
  $this->id = (int) $connection->lastInsertId();
  $connection = null;
}

//Updates current article object in the database
public function update(){
  //check whether article object has id
  if(is_null($this->id)){
    trigger_error("Attempted to insert an article that does not have an ID into the database",E_USER_ERROR);
    return;
  }

  //update article
  $connection = new PDO(DB,DB_USER,DB_PASS);
  $sqlQuery = "UPDATE articles SET publicationDate=FROM_UNIXTIME(:publicationDate),title=:title,summary=:summary,content=:content WHERE id=:id";
  $statement = $connection->prepare($sqlQuery);
  $statement->bindValue(":id",$this->id,PDO::PARAM_INT);
  $statement->bindValue(":publicationDate",$this->publicationDate,PDO::PARAM_INT);
  $statement->bindValue(":title",$this->title,PDO::PARAM_STR);
  $statement->bindValue(":summary",$this->summary,PDO::PARAM_STR);
  $statement->bindValue(":content",$this->content,PDO::PARAM_STR);
  $statement->execute();
  $connection = null;
}

//delete current article object from database
public function delete(){

  //does article have an id in database?
  if(is_null($this->id)){
    trigger_error("Article cannot be deleted from database: No known ID!",E_USER_ERROR);
    return;
  }

  $connection = new PDO(DB,DB_USER,DB_PASS);
  $sqlQuery = "DELETE FROM articles WHERE id=:id";
  $statement = $connection->prepare($sqlQuery);
  $statement->bindValue(":id",$this->id,PDO::PARAM_INT);
  $statement->execute();
  $connection = null;
}

}

 ?>

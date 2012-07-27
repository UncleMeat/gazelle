<?
 
//header('Content-Type: application/json; charset=utf-8');
 
// trim whitespace before setting/evaluating these fields
$Name = db_string(trim($_POST['name']));
$Title =  db_string(trim($_POST['title']));
$Image =  db_string(trim($_POST['image']));
$Body =  db_string(trim($_POST['body']));
$Category = (int)$_POST['category'];
$TagList = db_string(trim($_POST['tags']));
$Public = $_POST['ispublic']==1?1:0;
$UserID = (int)$LoggedUser['ID'];
        
//TODO: add max number of templates

if ($Name=='') { 
    
    echo "Error: No name set";
    
} else if ($Title=='' && $Image=='' && $Body=='' && $TagList=='' ) {
    
    echo "Cannot save a template with no content!";
    
} else {
    
    $DB->query("INSERT INTO upload_templates 
                          (UserID, TimeAdded, Name, Public, Title, Image, Body, CategoryID, Taglist) VALUES 
        ('$UserID', '".sqltime()."', '$Name', '$Public', '$Title', '$Image', '$Body', '$Category', '$TagList')  ");

    $TemplateID = $DB->inserted_id();

    $Cache->delete_value('templates_ids_' . $LoggedUser['ID']);
    echo $TemplateID;
}

?>

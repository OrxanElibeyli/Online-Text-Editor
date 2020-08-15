<?php 

define("PATH_TO_FILE","./textEditor");

if(!is_dir(PATH_TO_FILE)) die("this is not directory");
if(!($dr=dir(PATH_TO_FILE))) die("directory can not open");



if(isset($_POST["submit"]))
{
  createFile();
}
elseif(isset($_GET["fileName"]))
{
  editFile($_GET["fileName"]);
}
elseif(isset($_POST["save"]))
{
  saveFile();
}
else
{
  displayHome($dr);
}

function saveFile()
{
  $fileName=basename($_POST["fileName"]);
  echo "filename---->" . $fileName;
  $filePath=PATH_TO_FILE . "/$fileName";
  file_put_contents($filePath,$_POST["editArea"]);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>editor</title>
  <style>
    .border
    {
      border: 1px solid;
    }
  </style>
</head>
<body>

<?php
function displayHome($dr)
{  ?>
  <form action="draft.php">
  <table class="border">
    <tr class="border">
      <th>file name</th>
      <th>szie</th>
      <th>last modified</th>
    </tr>
    
      
        <?php 
          while($file=$dr->read())
          {
            $filePath=PATH_TO_FILE . "/$file";
            echo '<tr><td><a href="draft.php?fileName=' . $file . '">'. $file . '</a></td>';
            echo "<td>" .filesize($filePath) . "</td>";
            echo "<td>" . filemtime($filePath) . "</td></tr>";
          }

          $dr->close();
        ?>
  </table>
  <h1>... or create new file</h1>
  <table>
    <tr>
      <td><label for="newFile">new file</label></td>
      <td><input type="text" name="newFile"></td>
    </tr>
    <tr>
      <td><input type="submit" name="submit" value="submit"></td>
    </tr>
  </table>

</form>
  <?php
} ?>




<?php

    function editFile($fileName)
    { 
      echo '<h1>editing '. $fileName . ' file.</h1>';
      echo '<form action="draft.php" method="post">';
      $filePath=PATH_TO_FILE . "/$fileName";
      echo '<input type="hidden" name="fileName" value="' . $fileName. '">';
      echo '<textarea name="editArea" id="" cols="30" rows="10">';
      echo htmlspecialchars(file_get_contents($filePath));
      echo '</textarea>'; ?>

      <br>
      <input type="submit" name="save" value="save">
      <input type="submit" name="cancel" value="cancel">

    <?php
    }

  ?>

</form>

</body>
</html>
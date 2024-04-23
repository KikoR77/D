<?php
        
    $imgId = array();

    $phpFileUploadErrors = array (
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk. ',
        8 => 'A PHP extension stopped the file upload.',
    );

    
    if(isset($_FILES['image'])){
        
        $file_array = reArrayFiles($_FILES['image']);
        
        for ($i = 0; $i < count($file_array); $i++){
            if ($file_array[$i]['error']) 
            {
                ?> <div class="alert alert-danger">
                <?php echo $file_array[$i]['name'].'-'.$phpFileUploadErrors[$file_array[$i]['error']];
                ?> </div> <?php 
            }                     
            else {
                $extensions = array('jpg', 'png', 'jpeg');
  
                $file_ext = explode('.', $file_array[$i]['name']);            

                $name = $file_ext[0];
                $name = preg_replace("!-!", " ", $name);
                $name = ucwords($name);            
  
                $file_ext = end($file_ext);                               
                
                $new_img_name = uniqid("IMG-", true).'.'.$file_ext;

                $file_array[$i]['name'] = $new_img_name;

                if (!in_array($file_ext, $extensions))
                {
                    ?> <div class="alert alert-danger">
                    <?php echo "{$file_array[$i]['name']} - Invalid file extension!";
                    ?> </div> <?php
                }
                else {
                    $img_dir = 'uploads/'.$file_array[$i]['name'];
                    
  
                    move_uploaded_file($file_array[$i]['tmp_name'], $img_dir);
  
                    $sql = "INSERT IGNORE INTO images (img_name, img_dir) VALUES ('$name', '$img_dir')";
                    $conn->query($sql) or die($conn->error);
                
                    $sql2 = "SELECT id FROM images WHERE img_dir=?";
                    $stmt = mysqli_stmt_init($conn);

                    if(!mysqli_stmt_prepare($stmt, $sql2)) {
                        echo "SQL statement failed";
                    } else {
                        mysqli_stmt_bind_param($stmt, "s", $img_dir);
                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);

                        while($row = mysqli_fetch_assoc($result)) {
                            $imgId[] = $row['id'];
                        }

                    }              

                    ?> <div class="alert alert-success">
                    <?php echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']];
                    ?> </div> <?php
                }
            }
        }
    
    }                                                            
          
 function reArrayFiles (&$file_post) {
    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);
                
    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_ary;
}
  
function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
<?php 



function getTitle(){
 global $pageTitle ;


 if(isset($pageTitle)){
     echo $pageTitle;
 }else {
     echo "eCommerce";
 }
}
//clean string from stripslashes and spisial caracters
function clean_string_val($data){

    $data= trim($data);
    $data=filter_var($data , FILTER_SANITIZE_STRING);
    $data= stripslashes($data);
    $data= htmlspecialchars($data);

    return $data;
}
function redirectHome($msg ,$url=null, $interval=3){

   $link="";

   if($url===null){
       $url="index.php";
       $link ="HomePage";
   }elseif($url ==="back"){
       $url=isset($_SERVER["HTTP_REFERER"]) && !empty($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:"index.php";
       $link="PreviousPage";
   }else{
    $url=$url;
    $link = $url; 
   }
   echo $msg;
   echo "<div class='alert alert-info'>you will redirect to $link after $interval s .</div>";
   header("refresh:$interval; url=$url");
   exit;
  
}
// function check if item exists in database
function checkItemDb($select , $from ,$value ){

    global $conn;

    $stmt = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");
    $stmt->execute(array($value));
    $count = $stmt ->rowCount();
    return $count;

}

// count items from table
function countItems($item ,$table){
    global $conn;
    $stm = $conn->prepare("SELECT COUNT($item) FROM $table");
    $stm->execute();
    return $stm->fetchColumn();
}
//get latest item from table

function getLatestItem($select ,$table ,$order,$limit=5){
    global $conn;
    $stm = $conn->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
    $stm->execute();
    $data = $stm->fetchAll();
    return $data;
}


// cuntries name array 
$country_array = array("Afghanistan", "Aland Islands", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Barbuda", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Trty.", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Caicos Islands", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern Territories", "Futuna Islands", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard", "Herzegovina", "Holy See", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Jan Mayen Islands", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea", "Korea (Democratic)", "Kuwait", "Kyrgyzstan", "Lao", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "McDonald Islands", "Mexico", "Micronesia", "Miquelon", "Moldova", "Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "Nevis", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestinian Territory, Occupied", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Principe", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Barthelemy", "Saint Helena", "Saint Kitts", "Saint Lucia", "Saint Martin (French part)", "Saint Pierre", "Saint Vincent", "Samoa", "San Marino", "Sao Tome", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia", "South Sandwich Islands", "Spain", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "The Grenadines", "Timor-Leste", "Tobago", "Togo", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Turks Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "US Minor Outlying Islands", "Uzbekistan", "Vanuatu", "Vatican City State", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (US)", "Wallis", "Western Sahara", "Yemen", "Zambia", "Zimbabwe");

// get categories
function getcategories(){
    global $conn;
    $stm = $conn->prepare("SELECT * FROM categories");
    $stm->execute();
    $cats=$stm->fetchAll();
    return $cats;
}

// get items by category id

function getitemsbycategoryid($catid){
    global $conn ;
    $stm = $conn->prepare("SELECT * FROM items   WHERE catigory_id = ? AND approve = 1   ORDER BY add_date DESC");
    $stm->execute(array($catid));
    $items = $stm->fetchAll();
    return $items;
}

// get category name by Id
function getcatname($id){
    global $conn;
    $stm = $conn->prepare("SELECT name FROM categories WHERE id = ? LIMIT 1");
    $stm->execute(array($id));
    $name = $stm->fetch();
    return $name;
}


function getTableItems($tableName  , $where = null , $order = null){


     global $conn;
     $stm = $conn->prepare("SELECT * FROM $tableName  $where  $order");
     $stm->execute();
     $data= $stm->fetchAll();
     return $data;

}
function get_all($fields , $table , $where = null ,$and = null , $orderby=null ){

    global $conn;

    $stm=$conn->prepare("SELECT $fields FROM $table $where $and $orderby");
    $stm->execute();
    $data=$stm->fetchAll();
    return $data;

}
?>






<?php
include "signIn.php";
function connectingIt(){
$servername = "mysql.cs.uky.edu";
$username = "iyse222";
$password = logIn();
// create coonecttion:
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
try {
  $conn = new PDO("mysql:host=$servername;dbname=iyse222", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  //echo "Connection failed: " . $e->getMessage();
}
return $conn; // to retun the coonn
}
// not the get way, but post:                       maybe remove the next line.
if(isset($_POST['button1'])) {
  echo "This is Button1 that is selected";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style> 
    body {font-family: "Free Serif"; color:black;}
    .Atable { 
              border:1px solid black; 
              background-color: beige; 
              text-align: center;}
    .poisonous {border-top: 2px solid red; border-bottom: 2px solid red; 
                border-left: 2px solid  blue; border-right: 2px solid blue;}
    .inedible {border: 2px solid green;}
    .Multi {color:green;}
    .lingual {color:red;}
  </style>
  <meta charset="UTF-8">
  <title>Munshn Lunshn</title>
</head>
<body style="font-family: 'Free Serif' ; color:black;">
<!-- must use style attributes, not the <style section ! this will need different adjustments. ~ correct it. -->
<h1>Welcome to the High Times of Munshn Lunshn &#x2122;!</h1>
<p>All our clients are served right!<br><mark>See this website is under construction, as is our cafe.</mark></p>
<h2>See the menu</h2>
<!-- not the get way tho -->
<!-- <form method ="get"> -->
<form method ="post"> 
<table class = 'Atable'> 
    <tr> <!-- add the php to count how many times the button was accessed and add a feature to see the menu of the selected button  -->
    <!--  the button works now after fixing syntax errors with angle brackets and <style> -->

    <!-- after clicking here the snacks table puts up and displays the num of times it is accessed in php $_GET["botton0"]-->
      <td> <input type="submit" name="snackz" value ="snacks"> </input> </td> <td>&#x1F34E;</td> <!-- fix it ?  --> 
      <td> <input type="submit" name="drinkz" value ="drinks"> </input> </td> <td>&#x1F378;</td>
      <td> <input type="submit" name="mainz" value ="mains"> </input> </td> <td>&#x1F357;</td>
    </tr>
    <tr>
      <td> <input type="submit" name="desertz" value ="deserts"> </input> </td> <td>&#x1F382;</td>
      <td><input type="submit" name="for_kidz" value ="for kids"> </input> </td> <td>&#x1F37C;</td>
      <td><input type="submit" name="for_petz" value ="for pets"> </input> </td> <td>&#x1F415;</td>
    </tr>
    <tr>
      <td><input type="submit" name="takeoutz" value ="takeout"> </input> </td> <td>&#x1F355;</td>
       <td class= "inedible"> <input type="submit" name="inediblez" value ="inedible"> </input> </td> <td> &#x1F388;</td>
    <td class = "poisonous"> <input type="submit" name="poisonousz" value ="poisonous"> </input> </td> <td> &#x2620;</td>
   <!-- <td> <input type="submit" name="reset0" value ="start fresh"> </input> </td> --> 
    </tr>
  </table>
  </form> <!-- for the post way, not get </form>-->
  <!-- php stuffs -->
  <?php
  // make function to pass in the posts:
  // add a comments what each does:
  // the bigMenu is the name and the parameter it passes is $items
      function bigMenu ($items) {
      // make it modular:
      // echo the header
      echo "<h2> Details about $items </h2>";
      // example from dr. f's site
      // ie$sql = "SELECT price FROM menu WHERE category = ?;
      //$prepared = $pdo->prepare($sql);
      //$prepared->execute([$valueFromHTMLform]);
      // connect to the mysql from the above connection and the var $conn named it connectingIt
      $conn = connectingIt();
      // this is the prepare statement and coonect it to the ? marker to protect the site from attacks
      $stmt = $conn->prepare("select number from accesses where category = ?");

      $stmt->execute([$items]); // returns the row 
      // use the fetch to gather the data from the table
      $row =$stmt->fetch();
      // plus need to accumulate for it:
      $row= $row['number']; // comment: the class makes it red too
      // and tie the $row to the accumulation.

      echo "<p class = 'lingual'>You have requested this information $row times</p>"; // row is the number from the DB
      // and update the accesses with the acculation with this:
      $sql = "update accesses set number = number + 1 where category = ?";
      // another prepared statement for the incrementation:
      $stmt = $conn->prepare($sql); // this adds it up.
      // this excutes the incrementation:
      $stmt->execute([$items]); // returns the row 
      // does not return anything, it just displays a table
      //echo "stuffs"; // a test i used to debug mistakes i made to seee where my errors occured.
      // another function to display the table after the incrementation.
      tables($items);
      //resetz($items); needs work
      }
      // create a function table: * 2
      function tables($items){
        // connect to mysql again in this function:
        $conn = connectingIt();
        // another prepared statement for the the table of each item:
        $sql = "select item, description, price from menu where category = ?";

        $stmt = $conn->prepare($sql); // this adds it up. // prepare make the website safer

        $stmt->execute([$items]); // good - > check
// use fetch again:
        //$row =$stmt->fetch(); // fetching the info from the DB
        // make a table:
        echo "<table class = 'Atable'>";
        // rows wit headers next:
        echo"<tr>";
        echo"<th>Item</th>"; // row 1 and so on, 2, 3
        echo"<th>Description</th>";
        echo"<th>Price</th>";
        echo"</tr>";
        // comment the while loop: which loops thru each item, descriptions, and prices
        // for like snacks and drinks
        while($row = $stmt->fetch()) {
        echo "<tr>"; // another secion for the row
        echo"<td>".$row['item']."</td>";
        echo"<td>".$row['description']."</td>"; // dot add the parts together!!!
        echo "<td>".$row['price']."</td>";
        echo "</tr>";
        }
        echo "</table>";
      } // maybe remove the reset function still working on it
      
      //function resetz ($items){         // add a reset function:
        //$conn = connectingIt();
        //$sql = "update accesses set number = 0 where category = ?";
        //$stmt = $conn->prepare($sql); // this adds it up.
        //$stmt->execute([$items]); // returns the row 
      //} 
      if(isset($_POST['snackz'])) {
        bigMenu ("snacks");    
      }
      else if (isset($_POST['drinkz'])) {
        bigMenu ("drinks"); 
      }
      else if(isset($_POST['mainz'])) {
        bigMenu ("mains"); 
      }
      else if (isset($_POST['desertz'])) {
        bigMenu ("deserts"); 
      }
      elseif(isset($_POST['for_kidz'])) {
        bigMenu ("for kids"); 
      }
      elseif(isset($_POST['for_petz'])) {
        bigMenu ("for pets"); 
      }  
      elseif(isset($_POST['takeoutz'])) {
        bigMenu ("takeout"); 
      }
      elseif(isset($_POST['inediblez'])) {
        bigMenu ("inedible"); 
      }
      else if (isset($_POST['poisonousz'])) {
        bigMenu ("poisonous"); 
      }
      //else if (isset($_POST['reset0'])){
        //bigMenu ("start fresh");
      //}
  ?>
  <h2>We are hiring!</h2>
  <p>We are looking for employees who are</p>
<ol>
<li> Reliable </li>
<li> Prompt </li>
<li> Friendly
  <ul>
    <li> Able to deal with <i>obnoxious customers</i></li>
    <li> Able to deal with <i>critical managers</i></li>
    <li> Able to cater to <i>the chef's whims</i></li>
  </ul>
</li>
<li><span class = "Multi">Multi</span><span class = "lingual">lingual</span> </li>
<li> <b>Healthy</b> <!--too far apart ? why? make comments to clear it up and a make file to explain what was added in the bonus. descriptors  -->
</li>
</ol>
</body>
</html>
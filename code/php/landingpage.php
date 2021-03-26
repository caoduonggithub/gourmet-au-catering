<?php 
  define ("MIN_RATION", 1);

  // initial current time
  $date = date("Y-m-d");
  $time = date("h:i");
  $current = $date."T".$time;

  // initial value for inputs
  $name = $phone = $address = $note = "";
  $submit = "send message";
  $numOfPeo = NAN;
  $deadline = $current;

  // initial value for error
  $nameError = $phoneError = $numOfPeoError = $addressError = $deadlineError = "";

  // check data when form is send
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // check name
    if (empty($_POST["name"])) {
      $nameError = "Name is required !";
    }
    else {
      $name = filter($_POST["name"]);
      if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameError = "Only letters and white space allowed";
      }
    }

    // check phone
    if (empty($_POST["phone"])) {
      $phoneError = "Phone is required !";
    }
    else {
      $phone = filter($_POST["phone"]);
    }

    // check address
    if (empty($_POST["address"])) {
      $addressError = "Address is required !";
    }
    else {
      $address = filter($_POST["address"]);
    }

    // check number of people
    if (empty($_POST["num-of-peo"])) {
      $numOfPeoError = "Number of people is required !";
    }
    else {
      $numOfPeo = $_POST["num-of-peo"];
    }

    // check deadline
    if (empty($_POST["deadline"])) {
      $deadlineError = "Deadline is required !";
    }
    else {
      $deadline = $_POST["deadline"];
      $currentTime = strtotime($current);
      $deadlineTime = strtotime($deadline);
      if ($currentTime >= $deadlineTime) {
        $deadlineError = "Can not delivery to the past !";
      }
    }

    // check note
    if (!empty($_POST["note"])) {
      $note = filter($_POST["note"]);
    }
  }

  // insert to database, table "customer", table "custom_order"




  function filter($data) {
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
 ?>



<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gourmet Catering</title>
</head>
<body>
  <header>
    <nav>
      <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
        class="nav-right">Gourmet au Catering</a>
      <a href="#" class="nav-left">About</a>
      <a href="#" class="nav-left">Menu</a>
      <a href="#" class="nav-left">Contact</a>
    </nav>
    <div id="logo">
      <h1>Le Catering</h1>
    </div>
  </header>

  <content>
    <div id="about">
      <div id="about-img">
        <img src="" alt="">
      </div>

      <div id="about-content">
        <h1>About Catering</h1>
        <h5>Tradition since 1889</h5>
        <p>The Catering was founded in blabla by Mr. Smith in lorem ipsum dolor sit amet, consectetur adipiscing elit consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute iruredolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.We only use seasonalsunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do ingredients.</p>
        <p>Excepteur sint occaecat cupidatat non proident,  eiusmod temporincididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      </div>
      <hr>
    </div>

    <div id="menu">
      <div id="menu-content">
        <h1>Our Menu</h1>
        <div class="food-details"></div>
      </div>

      <div id="menu-img">
        <img src="" alt="">
      </div>
    </div>

    <div id="contact">
      <h1>Contact</h1>
      <p>We offer full-service catering for any event, large or small. We understand your needs and we will cater the food to satisfy the biggerst criteria of them all, both look and taste. Do not hesitate to contact us.</p>
      <p>Catering Service, 42nd Living St, 43043 New York, NY</p>
      <p>You can also contact us by phone 00553123-2323 or email catering@catering.com, or you can send us a message here:</p>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" 
        method="post" id="customer-order">
        <p>
          <input type="text" name="name" placeholder="Name" 
          value="<?php echo $name; ?>">
          <span class="error-input">* <?php echo $nameError; ?></span>
        </p>
        <p>
          <input type="text" name="phone" placeholder="Phone" 
          value="<?php echo $phone; ?>">
          <span class="error-input">* <?php echo $phoneError; ?></span>
        </p>
        <p>
          <input type="number" min="<?php echo MIN_RATION; ?>" name="num-of-peo" 
          placeholder="How many people" value="<?php echo $numOfPeo; ?>">
          <span class="error-input">* <?php echo $numOfPeoError; ?></span>
        </p>
        <p>
          <input type="datetime-local" name="deadline" placeholder="Date and time"
          min="<?php echo $current; ?>" value="<?php echo $deadline; ?>">
          <span class="error-input"><?php echo $deadlineError; ?></span>
        </p>
        <p>
          <input type="text" name="address" placeholder="Address" 
          value="<?php echo $address; ?>">
          <span class="error-input">*<?php echo $addressError; ?></span>
        </p>
        <textarea name="note" placeholder="Message \ Special requirements" 
        form="customer-order"><?php echo $note; ?></textarea>
        <p>
          <input type="submit" name = "submit" value="<?php echo $submit; ?>">
        </p>
      </form>
    </div>

  </content>

  <footer>
    
  </footer>

</body>
</html>




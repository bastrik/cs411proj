<?
ini_set('max_execution_time', 3000);
session_start();
$login = isset($_SESSION['admin'])&&$_SESSION['admin']==1;
if(!$login){
    header("location:/\$topstack");
    die();
}
require_once("connect.php");
$message = '<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Happy New Years!</title>
</head>

<body bgcolor="#f6f6f6">

<!-- body -->
<table class="body-wrap" bgcolor="#f6f6f6" style="padding: 20px;
  width: 100%;">
  <tr>
    <td></td>
    <td class="container" bgcolor="#FFFFFF" style="clear: both !important;
  display: block !important;
  margin: 0 auto !important;
  max-width: 600px !important; padding: 20px; border: 1px solid #f0f0f0;">

      <!-- content -->
      <div class="content" style=" display: block;
  margin: 0 auto;
  max-width: 600px;">
      <table>
        <tr>
          <td>
          	<h1>Hi from Stacksity!</h1>
            <p>This is just a brief message, but we sincerely hope you take the time to read it</p>
            <p>First of all, thank you for signing up with Stacksity, for being the pioneers, the innovators and the trend setters. We&#39;ll very rarely send you emails like this,
            and only for special occasions. You can trust us.</p>
            <h2>We&#39;ve arrived a finished product,</h2>
            <p>which is why we want you to come join us again. Don&#39;t worry we are still committed to improving Stacksity at every chance we get. So come on over, have some laughs, find something interesting, and keep in touch. With more posts, comments and users Stacksity is growing well and we need you on it.</p>
            <p>For the small group of students working on this, <b>it means everything</b> to see you back on.</p>
            <p>It might have been awhile for you, but we&#39;ve been hard at work on Stacksity for a year now. Plenty of changes driven by you as well: from iOS and Android apps to a better interface, from <b>NSFW</b> features to geolocation. There&#39;s plenty more but that&#39;s up to you to find out.</p>
            <table class="btn-primary" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 10px;
  width: auto !important; width: 100%;">
              <tr>
                <td style="background-color: #348eda;
  border-radius: 25px;
  font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
  font-size: 14px;
  text-align: center;
  vertical-align: top;">
                  <a href="https://stacksity.com" style="background-color: #348eda;
  border: solid 1px #348eda;
  border-radius: 25px;
  border-width: 10px 20px;
  display: inline-block;
  color: #ffffff;
  cursor: pointer;
  font-weight: bold;
  line-height: 2;
  text-decoration: none;">Easy Stacksity Link</a>
                </td>
              </tr>
            </table>
            <!-- /button -->
            <p>Thanks for your time, and have a great 2016!</p>
            <p>-The Stacksity Team</p>
          </td>
        </tr>
      </table>
      </div>
      <!-- /content -->

    </td>
    <td></td>
  </tr>
</table>
<!-- /body -->

</body>
</html>';
$sql = mysqli_query($con, "SELECT email FROM users");
if(!is_null($sql)){
    while($row = mysqli_fetch_assoc($sql)){
        $to = $row['email'];
        $from = "Support@stacksity.com";
        $headers = "From: $from\r\n";
        $headers .= "Content-type: text/html\r\n";
        $subject = "Stacksity is Ready!";
        mail($to,$subject,$message,$headers);
    }}else{
    echo("it is a no go");
}
?>

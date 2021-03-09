<?php namespace App\Views;

    use App\Helpers\Token;
    class Home
    {
        public function loadBody()
        {

        }
    }
?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<navi>
    <a href="/">home</a>
    <a href="/test">test</a>
</navi>
</head>
<body>
<?php 
     Token::setUUID(md5(uniqid()));
     $_SESSION['add_user_token'] = Token::getUUID();
?>
<form method="post" action="">
<input type="hidden" name="cookingrecipes" id="cookingrecipes" value="<?php echo Token::getUUID(); ?>"/>
<input type="submit" name="submit" class="button" id="submit_btn" value="Send" />
</form>
<script>
$(document).ready(()=>{
    $('form').on('submit', (e)=>{

        $.post('/addAttendee', {cookingrecipes:document.getElementById('cookingrecipes').value}, (data, status)=>{console.log(data);})
        e.preventDefault();

        location.href="/";
    });
});
</script>

</body>
</html>

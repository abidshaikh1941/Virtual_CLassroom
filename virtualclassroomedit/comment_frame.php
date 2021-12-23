
<html>

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets\css\styling.css">
</head>

<body>

	<?php
require_once 'includes/form_handlers/commentframe_handler.php';?>
    <div class="comment_wrapper">
        <script>
            function toggle() {
                var element = document.getElementById("comment_section");

                if (element.style.display == "block")
                    element.style.display = "none";
                else
                    element.style.display = "block";
            }
        </script>

        

        <form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id; ?>" method="POST" autocomplete="off">
            <input type="text" name="post_body" placeholder="Add a comment">
            <input type="submit" name="postComment<?php echo $post_id; ?>" value="Post">

        </form>

        <!-- Load comments -->
       


    </div>
</body>

</html> 
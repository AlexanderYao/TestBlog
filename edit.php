<?php
require_once("constant.php");
require_once(PATH_BLOG.DS."blog_repo.php");

if(isset($_GET["id"])){
    $id = $_GET["id"];
    $blog = BlogRepo::get_instance()->get_blog($id);
}
?>
<html>
<head>
<title>编辑日志</title>
<link rel="stylesheet" type="text/css" href="site.css">
<script type="text/javascript" src="jquery-1.9.1.js"></script>
<script type="text/javascript">
function save(){
    var id = $("#id").val();
    var title = $("#title").val();
    var content = $("#content").val();
    var method = id == ""? "insert":"update";
    $.post("blog/blog_controller.php",
    {
        id:id,
        title:title,
        content:content,
        method:method
    },
    function(data, status){
        if(status == "success"){
            alert("保存成功！");
            close();
        }else{
            alert("保存失败！原因："+status);
        }
    });
}
</script>
</head>
<body>
<div class="edit-row">
<div class="edit-left">id:</div>
<input type="text" id="id" readonly="true" value="<?php if(isset($blog)) echo $blog->_id; ?>" >
</div>
<div class="edit-row">
<div class="edit-left">title:</div>
<input type="text" id="title" value="<?php if(isset($blog)) echo $blog->_title; ?>" >
</div>
<div class="edit-tool">
<input type="checkbox" name="sourceCode">源代码|
<input type="button" value="标题">|
<input type="button" value="code">|
<input type="button" value="图片">
</div>
<div class="edit-content">
<textarea rows="35" cols="100" id="content"><?php if(isset($blog)) echo $blog->_content; ?></textarea>
</div>
<br/>
<div class="command">
<input type="button" value="save" onclick="save()">
</div>
</body>
</html>

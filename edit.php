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
<link rel="stylesheet" type="text/css" href="sunburst.css">
<script type="text/javascript" src="string.js"></script>
<script type="text/javascript" src="prettify.js"></script>
<script type="text/javascript" src="jquery-1.9.1.js"></script>
</head>
<body onload="preview()">
<div class="edit-row">
<div class="edit-left">id:</div>
<input type="text" id="id" readonly="true" value="<?php if(isset($blog)) echo $blog->_id; ?>" >
</div>
<div class="edit-row">
<div class="edit-left">title:</div>
<input type="text" id="title" value="<?php if(isset($blog)) echo $blog->_title; ?>" >
</div>
<div class="edit-tool">
<div class="edit-tool-left">
<input type="checkbox" id="sourceCode">
<label for="sourceCode">源代码</label></input>|
<input type="button" id="h3" value="标题h3">|
<input type="button" id="code" value="code">|
<input type="button" id="pic" value="插入图片">
</div>&nbsp;
<div class="edit-tool-right">
<input type="button" id="preview" value="预览" onclick="preview()">
<input type="button" value="save" onclick="save()">
</div>
</div>
<div class="edit-content">
<textarea rows="35" cols="100" id="blogEdit" onKeyDown="savePos(this)" onKeyUp="savePos(this)" onMouseDown="savePos(this)" onMouseUp="savePos(this)" onFocus="savePos(this)"><?php if(isset($blog)) echo $blog->_content; ?></textarea>
<div id="blogPreview"></div>
</div>
<div id="divUpload">
<form id="myupload" action="upload.php" method="post" enctype="multipart/form-data">
<input type="file" name="file">
<input type="submit" value="submit">
</form>
</div>
<script type="text/javascript">
var start = null;
var end = null;
$("#h3").click(function(){
    if(start == null || end == null || start == end) return;
    var txt = $("#blogEdit").val();
    var target = txt.slice(start,end);
    var pre = txt.slice(0,start);
    var post = txt.slice(end);
    var result = String.format("{0}<{1}>{2}</{1}>{3}",pre,"h3",target,post); 
    $("#blogEdit").val(result);
    start = null;
    end = null;
});

$("#code").click(function(){
    if(start == null || end == null || start == end) return;
    var txt = $("#blogEdit").val();
    var target = txt.slice(start,end);
    var pre = txt.slice(0,start);
    var post = txt.slice(end);
    var result = String.format('{0}<pre class="prettyprint linenums">{1}</pre>{2}',pre,target,post); 
    $("#blogEdit").val(result);
    start = null;
    end = null;
});

$("#divUpload").hide();

$("#pic").click(function(){
    //上传图片，并插入到光标处        
    var picPos = $("#pic").position();
    $("#divUpload").css("left",picPos.left);
    $("#divUpload").css("top",picPos.top+$("#pic").height());
    $("#divUpload").show();
});

function savePos(textArea){
    if(typeof(textArea.selectionStart) == "number"){
        start = textArea.selectionStart;
        end = textArea.selectionEnd;
    }
}

function preview(){
    $("#blogPreview").html($("#blogEdit").val());
    prettyPrint();
}

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
</body>
</html>

<html>
<head>
<title>管理日志</title>
<link rel="stylesheet" type="text/css" href="site.css">
<script type="text/javascript" src="jquery-1.9.1.js"></script>
</head>
<body>
<div>
<input id="insert" type="button" value="insert">
<input id="update" type="button" value="update">
<input id="delete" type="button" value="delete">
</div>
<div>
<table id="table">
<thead><tr>
<th>id</th><th>title</th><th>created</th>
</tr></thead>
<tbody>
<?php
require_once("constant.php");
require_once(PATH_BLOG.DS."blog_repo.php");
$blogs = BlogRepo::get_instance()->get_blogs();
foreach($blogs as $blog){
    printf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>',$blog->_id,$blog->_title,$blog->_created);
}
?>
</tbody>
</table>
</div>
<script type="text/javascript">
$("#table tbody tr").click(function(){
    $("#table tbody tr").removeClass("selected");
    $(this).addClass("selected");
});

$("#insert").click(function(){
    window.open("edit.php");        
});

$("#update").click(function(){
    var row = $("#table tr.selected");
    var id = row.children(":eq(0)").text();
    window.open("edit.php?id="+id);
});

$("#delete").click(function(){
    var id = $("#table tr.selected").children(":eq(0)").text();
    if(!confirm("确定要删除这篇博文吗？")) return;
    $.post("blog/blog_controller.php",
        {id:id,method:"delete"},
        function(data,status){
            if(status == "success"){
                alert("删除成功！");
                $("#table tr.selected").remove();
            }else{
                alert("删除失败，具体请参见日志！");
            }
        });
});
</script>
</body>
</html>

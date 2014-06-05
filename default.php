<html>
<head>
<title>大尧日志</title>
<link rel="icon" type="image/x-icon" href="yao.png"/>
<link rel="stylesheet" type="text/css" href="site.css"/>
<link rel="stylesheet" type="text/css" href="sunburst.css"/>
<script type="text/javascript" src="string.js"></script>
<script type="text/javascript" src="prettify.js"></script>
<script language="javascript" type="text/javascript">
function addNewTabOrActivate(target){
    var targetNode = null;
    var nodeList = document.getElementsByClassName("tabs")[0].childNodes;
    for(index in nodeList){
        if(nodeList[index].nodeType == 1 && nodeList[index].attributes["tag"].value == target.attributes["tag"].value){
            targetNode = nodeList[index];
            break;
        }
    }
    if(targetNode != null){
        activateTab(targetNode);
        return;
    }
    var template = String.format('<div class="tab" tag="{0}"><div class="left"></div><div class="center" onclick="activateTab(this.parentNode)">{1}</div><div class="right" onmouseover="focusRight(this)" onmouseout="unfocusRight(this)" onclick="closeTab(this.parentNode)">&nbsp;</div></div>',target.attributes["tag"].value,target.innerHTML);
    document.getElementsByClassName("tabs")[0].innerHTML += template;
    activateTab(document.getElementsByClassName("tabs")[0].lastChild);
}

var activeTab = null;
function activateTab(id){
    if(id==activeTab) return;
    var nodeList = id.parentNode.childNodes;
    for(index in nodeList){
        if(nodeList[index].nodeType == 1) nodeList[index].className = "tab";
    }
    activeTab = id;
    id.className="activeTab"; 

    var tag = id.attributes["tag"].value;
    if(tag.indexOf(".html") > -1){
        document.getElementById("blog").innerHTML = '起始页';
    } else {
        showBlog(tag);
    }
}

function showBlog(id){
    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.getElementById("blog").innerHTML = request.responseText;
            prettyPrint();
        }
    }
    request.open("GET","blog/blog_controller.php?id="+id);
    request.send();
}

function focusRight(target){
    target.className = "right-focus";
}

function unfocusRight(target){
    target.className = "right";
}

function closeTab(target){
    var acTab = target.nextSibling?target.nextSibling:(target.previousSibling?target.previousSibling:null);
    if(acTab!=null) activateTab(acTab);
    target.parentNode.removeChild(target);
}
</script>
</head>
<body>
    <div class="header">
        <div class="logo"><h2><a href="default.php" target="_self">大尧-AlexanderYao</a></h2></div>
        <div class="tagline">读书、学习、思考、笃行</div>
        <div class="banner"></div>
    </div>
<div class="body">
    <div class="navigation">
        <ul type="circle">
<?php 
require_once("constant.php");
require_once(PATH_BLOG.DS."blog_repo.php");
$blogs = BlogRepo::get_instance()->get_blogs();
foreach($blogs as $blog){
    printf('<li><div tag="%1$s" title="%2$s" onclick="addNewTabOrActivate(this)">%2$s</div></li>',$blog->_id,$blog->_title);
}
?>
        </ul>
    </div>
    <div class="content" id="content">
        <div class="tabs"><div class="activeTab" tag="start.html">
            <div class="left"></div>
            <div class="center" onclick="activateTab(this.parentNode)">起始页</div>
        </div></div>
        <div id="blog"></div>
    </div>
</div>
</body>
</html>

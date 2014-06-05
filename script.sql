alter database test default character set utf8 collate utf8_general_ci;

create table blogs (
	id int(10) unsigned auto_increment primary key,
	title varchar(200) not null,
	content longtext not null,
	created datetime not null
);

alter table blogs convert to character set utf8 collate utf8_general_ci;

insert into blogs values (null, '一个最简单的页面', '只有一句话', now());

insert into blogs values (null, '一篇技术博文的典型要素', '<h1>一篇技术博文的典型要素</h1>
<p>首先是一段说明性的文字。比如：所谓闭包，一般的函数一旦出了{}，局部变量就没了。闭包的函数在执行完之后，仍然存在于堆里，像一个对象。</p>
<h3>一、第一部分</h3>
<p>是一段代码：</p>
<pre class="prettyprint linenums">
function f1(){
    var n = 1;
    function f2(){
        alert(n);
    }
    return f2;
}
var result = f1();
result(); // 1
</pre>
<br/>
<h3>二、第二部分</h3>
<p>是若干图片：</p>
<div>
<img src="../feed.png" alt="feed"/>
</div>
<br/>
<h3>三、第三部分</h3>
<p>最后是若干结论。。。</p>', now());

insert into blogs values (null, 'EntityFramework查询oracle数据库时报ora-12704:character set mismatch', '<h3>EntityFramework查询oracle数据库时报ora-12704:character set mismatch</h3>
<p>1、这段linq，执行期间报ora-12704:character set mismatch错误。</p>
<pre class="prettyprint linenums">
var query = from m in ctx.MENU
    where (m.SUPER_MENU_ID ?? "") == (parentMenuId ?? "")
    orderby m.SORT_ID descending
    select new { m.SORT_ID };
</pre>
<p>生成出来的sql如下：</p>
<pre class="prettyprint linenums">
SELECT "Project1"."SORT_ID" AS "SORT_ID"
   FROM (

SELECT "Extent1"."SORT_ID" AS "SORT_ID"
  FROM "BA"."MENU" "Extent1"
 WHERE ((CASE WHEN("Extent1"."SUPER_MENU_ID" IS NULL) THEN '' 
              ELSE "Extent1"."SUPER_MENU_ID" END) =
        (CASE WHEN(&p__linq__0 IS NULL) THEN '' 
              ELSE &p__linq__0 END))

) "Project1"
ORDER BY "Project1"."SORT_ID" DESC
</pre>
<p>但是这条sql单独放到plsql里跑是OK的。</p>
<br/>
<p>2、改成这样，让生成的sql去掉里面的case when就OK了。</p>
<pre class="prettyprint linenums">
parentMenuId = parentMenuId ?? "";
var query = from m in ctx.MENU
    where m.SUPER_MENU_ID == parentMenuId
  orderby m.SORT_ID descending
   select new {m.SORT_ID};
</pre>
<p>生成的sql如下：</p>
<pre class="prettyprint linenums">
SELECT "Project1"."SORT_ID" AS "SORT_ID"
   FROM (

SELECT "Extent1"."SORT_ID" AS "SORT_ID"
  FROM "BA"."MENU" "Extent1"
 WHERE ("Extent1"."SUPER_MENU_ID" = :p__linq__0)

) "Project1"
ORDER BY "Project1"."SORT_ID" DESC
</pre>
<br/>
<p>3、目前的猜测是，ef生成的case when有问题，调整linq不生成case when即可。但奇怪的是，同样的sql在plsql里跑居然也是OK的，手工修改客户端字符集也无法重现这个问题。</p>
<p>修改注册表：HKEY_LOCAL_MACHINE\SOFTWARE\ORACLE\KEY_OraClient11g_home2\NLS_LANG = SIMPLIFIED CHINESE_CHINA.AL32UTF8</p>
<br/>
<p>4、这个问题只是暂时解决，仍然存疑，待完善。主要参考这篇：</p>
<p><a href="http://blogs.planetsoftware.com.au/paul/archive/2010/09/24/ef4-part-8-database-agnostic-linq-to-entities.aspx" alt="ef4 part 8: database agnostic linq to entities">《ef4 part 8: database agnostic linq to entities》</a></p>
<div class="postDesc">
<img src="../feed.png" alt="feed"/>
posted @ 2014-02-27
</div>', now());

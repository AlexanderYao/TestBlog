<?php
define('_EXEC',1);
define('PATH_BASE',dirname(__FILE__)); printf("PATH_BASE = %s\n", PATH_BASE);

define('DS',DIRECTORY_SEPARATOR);
define('PATH_BLOG',PATH_BASE.DS.'blog');
printf("PATH_BLOG = %s\n", PATH_BLOG);

require_once(PATH_BASE.DS.'db.php');
require_once(PATH_BASE.DS.'util.php');
require_once(PATH_BLOG.DS.'blog.php');
require_once(PATH_BLOG.DS.'blog_repo.php');
require_once(PATH_BLOG.DS.'blog_view.php');

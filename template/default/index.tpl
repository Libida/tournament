<!doctype html>
<!--[if lt IE 7 ]> <html lang="{metaLanguage}" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]> <html lang="{metaLanguage}" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="{metaLanguage}" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="{metaLanguage}" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="{metaLanguage}" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>{title}</title>
    <base href="{baseHref}" />

    <meta name="description" content="{metaDescription}">
    <meta name="author" content="{metaPublisher}">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <meta name="application-name" content="{title}">
    <meta name="copyright" content="(c) 2012 Maria Rudko">
    <meta name="publisher" content="{metaPublisher}">
    <meta name="robots" content="INDEX, FOLLOW">
    <meta name="revisit-after" content="7 days">
    <meta name="MSSmartTagsPreventParsing" content="true">

    <!-- Share on Facebook -->
    <meta property="og:title" content="{title}" />
    <meta property="og:description" content="{metaDescription}" />
    <meta property="og:image" content="" />

    <link rel="stylesheet" href="template/{tplSetName}/css/{stylesheet}.css?v=1">

    <script src="js/libs/modernizr.min.js"></script>
    <script src="js/libs/jquery.min.js"></script>
    <script src="js/phpmyfaq.js"></script>

    <link rel="shortcut icon" href="template/{tplSetName}/favicon.ico">
    <link rel="apple-touch-icon" href="template/{tplSetName}/apple-touch-icon.png">

    <link rel="alternate" title="News RSS Feed" type="application/rss+xml" href="feed/news/rss.php">
    <link rel="alternate" title="TopTen RSS Feed" type="application/rss+xml" href="feed/topten/rss.php">
    <link rel="alternate" title="Latest FAQ Records RSS Feed" type="application/rss+xml" href="feed/latest/rss.php">
    <link rel="alternate" title="Open Questions RSS Feed" type="application/rss+xml" href="feed/openquestions/rss.php">
    <link rel="search" type="application/opensearchdescription+xml" title="{metaTitle}" href="{opensearch}">
</head>
<body dir="{dir}">

<!--[if lt IE 8 ]>
<div class="internet-explorer-error">
    Do you know that your Internet Explorer is out of date?<br/>
    Please use Internet Explorer 8+, Mozilla Firefox 4+, Google Chrome, Apple Safari 5+ or Opera 11+
</div>
 <![endif]-->

<div class="navbar navbar-inner clearfix">
    <div id="logo">
        <a href="/tournament/"><img src="images/logo.png" alt="Logo" title="Logo" width="30" height="30"
                                    border="0"/></a>
        <h1>{siteName}</h1>
    </div>
    <form action="{writeLangAdress}" method="post" class="pull-right">
    {switchLanguages}
        <input type="hidden" name="action" value=""/>
    </form>
    <ul class="nav pull-right">
        [notLoggedIn]
        <li class="{activeRegister}">{msgRegisterUser}</li>
        <li class="divider-vertical"></li>
        <li class="{activeLogin}">{msgLoginUser}</li>
        [/notLoggedIn]
        [userloggedIn]
        <li class="{activeUserControl}">{msgUserControl}</li>
        <li class="divider-vertical"></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <span title="{msgFullName}">{msgLoginName}</span><b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
                <li>{msgUserControlDropDown}</li>
                <li>{msgLogoutUser}</li>
            </ul>
        </li>
        [/userloggedIn]
    </ul>
</div>

<section id="main" class="clearfix">
    <div id="sideBar">
                    <ul class="nav nav-list categories">
                        <li>{news}</li>
                        <li>{players}</li>
                        <li>{tournaments}</li>
                    </ul>
               <p id="statistics">{userOnline}</p>
    </div>

            <div class="span6 main-content">
                {writeContent}
            </div>
</section>

<footer>
    <p>Copyright &copy; 2012 by <a target="_blank" href="mailto: myr-kat@bk.ru">Maryia Rudzko</a></p>
</footer>

</body>
</html>
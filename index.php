<?php

define("VERSION", "1.2");

include("./conf/config.inc.php");
include("./incl/functions.inc.php");
include("./lang/$language.inc.php");
include("./incl/header.inc.php");
include("./incl/html.header.inc.php");


/* register directory/filename */

if (isset($_GET['directory_name']))
{
    $directory_name = basename(stripslashes($_GET['directory_name']))."/";
}
if (isset($_GET['filename']))
{
    $filename = basename(stripslashes($_GET['filename']));
}
if (isset($_POST['directory_name']))
{
    $directory_name = basename(stripslashes($_POST['directory_name']))."/";
}
if (isset($_POST['filename']))
{
    $filename = basename(stripslashes($_POST['filename']));
}
if (isset($_POST['new_directory_name']))
{
    $new_directory_name = basename(stripslashes($_POST['new_directory_name']))."/";
}
if (isset($_POST['new_filename']))
{
    $new_filename = basename(stripslashes($_POST['new_filename']));
}


/* validate path */

if (isset($_GET['path']))
    $path = validate_path($_GET['path']);
else if (isset($_POST['path']))
    $path = validate_path($_POST['path']);

if (!isset($path) || $path == "./" || $path == ".\\" || $path == "/" || $path == "\\")
    $path = false;


if ( isset($_SESSION['session_loggedin']) || !$phpfm_auth )
{
    if (!(@opendir($home_directory.$path)) || (substr($home_directory, -1) != "/"))
    {
        print "<table class='output' width=400 cellpadding=0 cellspacing=0>";
        print "<tr><td align='center'>";

        if (!(@opendir($home_directory)))
            print "<font color='#CC0000'>$StrInvalidHomeFolder</font>";
        else if (!(@opendir($home_directory.$path)))
            print "<font color='#CC0000'>$StrInvalidPath</font>";
        if (substr($home_directory, -1) != "/")
            print "&nbsp;<font color='#CC0000'>$StrMissingTrailingSlash</font>";

        print "</td></tr>";
    print "</table><br />";
    }

    if (isset($_GET['action']) && is_file("incl/".$_GET['action'].".inc.php") && is_valid_name($_GET['action']))
        include("./incl/".basename($_GET['action']).".inc.php");
    else if (isset($_GET['output']) && is_file("incl/".$_GET['output'].".inc.php") && is_valid_name($_GET['output']))
    {
        print "<table class='output' width=400 cellpadding=0 cellspacing=0>";
            print "<tr><td align='center'>";
                include("./incl/".basename($_GET['output']).".inc.php");
            print "</td></tr>";
        print "</table><br />";

        include("./incl/filebrowser.inc.php");
    }
    else
    {
        include("./incl/filebrowser.inc.php");
    }
}
else
{
    include("./incl/login.inc.php");
}

include("./incl/footer.inc.php");

?>


<?php

if (!@include_once("./incl/auth.inc.php"))
 include_once("../incl/auth.inc.php");

if (!isset($_GET['sortby'])) $_GET['sortby']	= "filename";
if (!isset($_GET['order'])) $_GET['order']	= "asc";

print "<table class='menu' cellpadding=2 cellspacing=0>";
 print "<tr>";
  if ($AllowCreateFolder) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=create&amp;type=directory'><img align='absmiddle' src='icon/newfolder.gif' width=25 height=24 alt='$StrMenuCreateFolder' border=0>&nbsp;$StrMenuCreateFolder</a>&nbsp;&nbsp;</td>";
  if ($AllowCreateFile) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=create&amp;type=file'><img align='absmiddle' src='icon/newfile.gif' width=25 height=24 alt='$StrMenuCreateFile' border=0>&nbsp;$StrMenuCreateFile</a>&nbsp;&nbsp;</td>";
  if ($AllowUpload) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=upload'><img align='absmiddle' src='icon/upload.gif' width=25 height=24 alt='$StrMenuUploadFiles' border=0>&nbsp;$StrMenuUploadFiles</a>&nbsp;&nbsp;</td>";
  if ($AllowUpload) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."'><img align='absmiddle' src='icon/refresh.gif' width=25 height=24 alt='$StrMenuRefreshPage' border=0>&nbsp;$StrMenuRefreshPage</a>&nbsp;&nbsp;</td>";
  if ($phpfm_auth) print "<td align='center' valign='bottom'><a href='$base_url&amp;action=logout'><img align='absmiddle' src='icon/logout.gif' width=25 height=24 alt='$StrMenuLogOut' border=0>&nbsp;$StrMenuLogOut</a>&nbsp;&nbsp;</td>";
 print "</tr>";
print "</table><br />";

print "<table class='index' cellpadding=0 cellspacing=0>";
 print "<tr>";
  print "<td class='iheadline' colspan=4 align='center' height=21>";
   print "<font class='iheadline'>$StrIndexOf&nbsp;".get_linked_path($path,$base_url)."</font>";
  print "</td>";
 print "</tr>";
 print "<tr>";
  print "<td>&nbsp;</td>";
  print "<td class='fbborder' valign='top'>";



  if ($open = @opendir($home_directory.$path))
  {
   for($i=0;($directory = readdir($open)) != FALSE;$i++)
    if (is_dir($home_directory.$path.$directory) && $directory != "." && $directory != ".." && !is_hidden_directory($home_directory.$path.$directory))
      $directories[$i] = array($directory,$directory);
   closedir($open);

   if (isset($directories))
   {
    sort($directories);
    reset($directories);
   }
  }

  print "<table class='directories' width=90% cellpadding=1 cellspacing=0>";
   print "<tr>";
    print "<td class='bold'>&nbsp;</td>";
    print "<td class='bold'>&nbsp;$StrFolderNameShort</td>";
    if ($AllowRename) print "<td class='bold' align='center'>$StrRenameShort</td>";
    if ($AllowDelete) print "<td class='bold' align='center'>$StrDeleteShort</td>";
   print "</tr>";
   print "<tr>";
    print "<td><a href='$base_url' OnMouseOver=\"window.status='Home Directory';
return true\"><img src='icon/folder.gif' width=25 height=24 alt='Home Directory' border=0></a></td>";
    print "<td>&nbsp;<a href='$base_url' OnMouseOver=\"window.status='Home Directory';
return true\">.</a></td>";
    print "<td>&nbsp;</td>";
    print "<td>&nbsp;</td>";
   print "</tr>";
   print "<tr>";
    print "<td><a href='$base_url&amp;path=".htmlentities(rawurlencode(dirname($path)))."/' OnMouseOver=\"window.status='Up One Directory';
return true\"><img src='icon/folder.gif' width=25 height=24 alt='Up One Directory' border=0></a></td>";
    print "<td>&nbsp;<a href='$base_url&amp;path=".htmlentities(rawurlencode(dirname($path)))."/' OnMouseOut=\"window.status='GateQuest Documents Manager'; return true\" OnMouseOver=\"window.status='Up One Directory';
return true\">..</a></td>";
    print "<td>&nbsp;</td>";
    print "<td>&nbsp;</td>";
   print "</tr>";
  if (isset($directories)) foreach($directories as $directory)
  {
   print "<tr>";
    print "<td><a href='$base_url&amp;path=".htmlentities(rawurlencode($path.$directory[0]))."/' OnMouseOver=\"window.status='Open This Folder';
return true\"><img src='icon/folder.gif' width=25 height=24 alt='Open This Folder' border=0></a></td>";
    print "<td>&nbsp;<a href='$base_url&amp;path=".htmlentities(rawurlencode($path.$directory[0]))."/' OnMouseOver=\"window.status='Open This Folder';
return true\">".htmlentities($directory[0])."</a></td>";
    if ($AllowRename) print "<td align=\"center\"><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;directory_name=".htmlentities(rawurlencode($directory[0]))."/&amp;action=rename' OnMouseOver=\"window.status='Rename This Folder';
return true\"><img src='icon/rename.gif' width=25 height=24 alt='Rename This Folder' border=0></a></td>";
    if ($AllowDelete) print "<td align=\"center\"><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;directory_name=".htmlentities(rawurlencode($directory[0]))."/&amp;action=delete' OnMouseOver=\"window.status='Delete This Folder';
return true\"><img src='icon/delete.gif' width=25 height=24 alt='Delete This Folder' border=0></a></td>";
   print "</tr>";
  }
   print "<tr><td colspan=4>&nbsp;</td></tr>";
  print "</table>";

  print "</td>";
  print "<td>&nbsp;</td>";
  print "<td valign='top'>";



  if ($open = @opendir($home_directory.$path))
  {
   for($i=0;($file = readdir($open)) != FALSE;$i++)
    if (is_file($home_directory.$path.$file) && !is_hidden_file($home_directory.$path.$file))
    {
     $icon = get_icon($file);
     $filesize = filesize($home_directory.$path.$file);
     $permissions = decoct(fileperms($home_directory.$path.$file)%01000);
     $modified = filemtime($home_directory.$path.$file);
     $extension = "";
     $files[$i] = array(
                         "icon"        => $icon,
                         "filename"    => $file,
                         "filesize"    => $filesize,
                         "permissions" => $permissions,
                         "modified"    => $modified,
                         "extension"   => $extension,
                       );
    }
   closedir($open);

   if (isset($files))
   {
    usort($files, "compare_filedata");
    reset($files);
   }
  }

  print "<table class='files' width=90% cellpadding=1 cellspacing=0>";
   print "<tr>";
    print "<td class='bold'>&nbsp;</td>";
    print "<td class='bold'>&nbsp;<a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;sortby=filename&amp;order=".get_opposite_order("filename", $_GET['order'])."'>$StrFileNameShort</a></td>";
    print "<td class='bold' align='right' style='padding-right: 10px'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;sortby=filesize&amp;order=".get_opposite_order("filesize", $_GET['order'])."'>$StrFileSizeShort</a></td>";
    print "<td class='bold' align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;sortby=permissions&amp;order=".get_opposite_order("permissions", $_GET['order'])."'>$StrPermissionsShort</a></td>";
    print "<td class='bold' align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;sortby=modified&amp;order=".get_opposite_order("modified", $_GET['order'])."'>$StrLastModifiedShort</a></td>";
    if ($AllowView) print "<td class='bold' align='center'>$StrViewShort</td>";
    if ($AllowEdit) print "<td class='bold' align='center'>$StrEditShort</td>";
    if ($AllowRename) print "<td class='bold' align='center'>$StrRenameShort</td>";
    if ($AllowDownload) print "<td class='bold' align='center'>$StrDownloadShort</td>";
    if ($AllowDelete) print "<td class='bold' align='center'>$StrDeleteShort</td>";
   print "</tr>";
  if (isset($files)) foreach($files as $file)
  {
   $file['filesize'] = get_better_filesize($file['filesize']);
   $file['modified'] = date($ModifiedFormat, $file['modified']);

   print "<tr>";
    print "<td><img src='icon/".$file['icon']."' width=25 height=24 border=0></td>";
    print "<td>&nbsp;".htmlentities($file['filename'])."</td>";
    print "<td align='right' style='padding-right: 10px'>".$file['filesize']."</td>";
    print "<td align='center'>".$file['permissions']."</td>";
    print "<td align='center'>".$file['modified']."</td>";
    if ($AllowView && is_viewable_file($file['filename'])) print "<td align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=view&amp;size=100'><img src='icon/view.gif' width=25 height=24 alt='$StrViewFile' border=0></a></td>";
    else if ($AllowView) print "<td>&nbsp;</td>";
    if ($AllowEdit && is_editable_file($file['filename'])) print "<td align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=edit'><img src='icon/edit.gif' width=25 height=24 alt='$StrEditFile' border=0></a></td>";
    else if ($AllowEdit) print "<td>&nbsp;</td>";
    if ($AllowRename) print "<td align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=rename' OnMouseOut=\"window.status='GateQuest Documents Manager'; return true\" OnMouseOver=\"window.status='Rename This File';
return true\"><img src='icon/rename.gif' width=25 height=24 alt='$StrRenameFile' border=0></a></td>";
    if ($AllowDownload) print "<td align='center'><a href='incl/libfile.php?".session_id()."&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=download' OnMouseOut=\"window.status='GateQuest Documents Manager'; return true\" OnMouseOver=\"window.status='Download This File';
return true\"><img src='icon/download.gif' width=25 height=24 alt='$StrDownloadFile' border=0></a></td>";
    if ($AllowEdit) print "<td align='center'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($file['filename']))."&amp;action=delete' OnMouseOut=\"window.status='GateQuest Documents Manager'; return true\" OnMouseOver=\"window.status='Delete This File';
return true\"><img src='icon/delete.gif' width=25 height=24 alt='$StrDeleteFile' border=0></a></td>";
   print "</tr>";

  }
   print "<tr><td colspan=9>&nbsp;</td></tr>";
  print "</table>";


  print "</td>";
 print "</tr>";
print "</table>";

print "<br><table class='menu' cellpadding=2 cellspacing=0>";
 print "<tr>";
  if ($AllowCreateFolder) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=create&amp;type=directory'><img align='absmiddle' src='icon/newfolder.gif' width=25 height=24 alt='$StrMenuCreateFolder' border=0>&nbsp;$StrMenuCreateFolder</a>&nbsp;&nbsp;</td>";
  if ($AllowCreateFile) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=create&amp;type=file'><img align='absmiddle' src='icon/newfile.gif' width=25 height=24 alt='$StrMenuCreateFile' border=0>&nbsp;$StrMenuCreateFile</a>&nbsp;&nbsp;</td>";
  if ($AllowUpload) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."&amp;action=upload'><img align='absmiddle' src='icon/upload.gif' width=25 height=24 alt='$StrMenuUploadFiles' border=0>&nbsp;$StrMenuUploadFiles</a>&nbsp;&nbsp;</td>";
  if ($AllowUpload) print "<td align='center' valign='bottom'><a href='$base_url&amp;path=".htmlentities(rawurlencode($path))."'><img align='absmiddle' src='icon/refresh.gif' width=25 height=24 alt='$StrMenuRefreshPage' border=0>&nbsp;$StrMenuRefreshPage</a>&nbsp;&nbsp;</td>";
  if ($phpfm_auth) print "<td align='center' valign='bottom'><a href='$base_url&amp;action=logout'><img align='absmiddle' src='icon/logout.gif' width=25 height=24 alt='$StrMenuLogOut' border=0>&nbsp;$StrMenuLogOut</a>&nbsp;&nbsp;</td>";
 print "</tr>";
print "</table><br />";

?>


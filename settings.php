<?php
require('checkallowed.php'); // Check logged-in

if(!$_SESSION['gpx_perms']['perm_updetails']) die('Sorry, you do not have permission to access this page.  Please login and try again.');

// Get user info
$result_usr = $GLOBALS['mysqli']->query("SELECT 
                              theme,
                              language,
                              first_name,
                              last_name,
                              username,
                              email_address 
                            FROM users 
                            WHERE 
                              id = '$gpx_userid' 
                            LIMIT 1") or die('Unable to get your settings, please try again later.');

while($row_usr  = $result_usr->fetch_array())
{
    $usr_theme      = $row_usr['theme'];
    $usr_lang       = $row_usr['language'];
    $usr_fname      = $row_usr['first_name'];
    $usr_lname      = $row_usr['last_name'];
    $usr_usrname    = $row_usr['username'];
    $usr_email      = $row_usr['email_address'];
}
?>

<div class="infobox" style="display:none;"></div>

<div class="box" style="width:750px;">
<div class="box_title" id="box_servers_title"><?php echo $lang['settings']; ?></div>
<div class="box_content" id="box_servers_content">


<table border="0" cellpadding="2" cellspacing="0" width="700" class="cfg_table" style="margin-top:20px;">

<tr>
  <td><b><?php echo $lang['username']; ?>:</b></td>
  <td><?php echo strip_tags($_SESSION['gpx_username']); ?></td>
</tr>
<tr>
  <td><b><?php echo $lang['language']; ?>:</b></td>
  <td>
    <select id="usr_language" class="dropdown">
      <?php
      // No lang yet
      if(empty($usr_lang)) echo '<option value="" selected>'.$lang['none'].'</option>';
      
      // List everything in the 'languages/' dir
      if ($handle = opendir(DOCROOT.'/languages'))
      {
          while(false !== ($entry = readdir($handle)))
          {
              // Loop over PHP language files
              if(preg_match('/\.php$/i', $entry) && $entry != 'index.php')
              {
                  $opt_val  = str_replace('.php', '', $entry);
                  
                  if($usr_lang == $opt_val) echo '<option value="'.$opt_val.'" selected>'.ucwords($opt_val).'</option>';
                  else echo '<option value="'.$opt_val.'">'.ucwords($opt_val).'</option>';
              }
          }
          
          closedir($handle);
      }
      ?>
    </select>
  </td>
</tr>
<tr>
  <td><b><?php echo $lang['theme']; ?>:</b></td>
  <td>
    <select id="usr_theme" class="dropdown">
      <?php
      // List everything in the '/themes' dir
      if ($handle = opendir(DOCROOT.'/themes'))
      {
          while(false !== ($entry = readdir($handle)))
          {
              // Loop over themes
              if($entry != 'index.php' && !preg_match('/^\./', $entry) && !preg_match('/\.css$/i', $entry))
              {
                  if($usr_theme == $entry) echo '<option value="'.$entry.'" selected>'.ucwords($entry).'</option>';
                  else echo '<option value="'.$entry.'">'.ucwords($entry).'</option>';
              }
          }
          
          closedir($handle);
      }
      ?>
    </select>
  </td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>

<?php
// Check perm
if($_SESSION['gpx_perms']['perm_chpass'])
{
?>
<tr>
  <td><b><?php echo $lang['newpassword']; ?>:</b></td>
  <td><input type="password" id="usr_pass1" class="inputs" /></td>
</tr>
<tr>
  <td><?php echo $lang['newpassword_conf']; ?>:</td>
  <td><input type="password" id="usr_pass2" class="inputs" /></td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<?php } ?>

<tr>
  <td><b><?php echo $lang['email_address']; ?>:</b></td>
  <td><input type="text" value="<?php echo $usr_email; ?>" id="usr_email" class="inputs" /></td>
</tr>
<tr>
  <td><b><?php echo $lang['first_name']; ?>:</b></td>
  <td><input type="text" value="<?php echo $usr_fname; ?>" id="usr_fname" class="inputs" /></td>
</tr>
<tr>
  <td><b><?php echo $lang['last_name']; ?>:</b></td>
  <td><input type="text" value="<?php echo $usr_lname; ?>" id="usr_lname" class="inputs" /></td>
</tr>

<tr>
  <td colspan="2">&nbsp;</td>
</tr>

</table>
</div>


<div align="center">
  <div class="button" onClick="javascript:user_save(<?php echo $url_id; ?>);"><?php echo $lang['save']; ?></div>
</div>

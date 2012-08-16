<?php
/****************************************************************************
											./lang/de/ocstyle/removelogs.tpl.php
															-------------------
		begin                : July 9 2004

		For license information see doc/license.txt
 ****************************************************************************/

/****************************************************************************
	  
   Unicode Reminder メモ
                                       				                                
	 remove a cache log
		
		cachename
		logid_urlencode
		log

 ****************************************************************************/
?>
<form action="removelog.php" method="post" enctype="application/x-www-form-urlencoded" name="removelog_form" dir="ltr">
<input type="hidden" name="commit" value="1"/>
<input type="hidden" name="logid" value="{logid}"/>
<table class="content">
	<tr><td class="header" colspan="2"><img src="lang/de/ocstyle/images/description/22x22-logs.png" border="0" width="32" height="32" alt="" title="" align="middle"> <b>{t}Remove log entry for <a href="viewcache.php?cacheid={cacheid}">{cachename}</a>{/t}</b></td></tr>
	<tr><td class="spacer"></td></tr>

	<tr><td>{t}Are you sure to remove your log entry?{/t}</td></tr>
	<tr><td class="spacer"></td></tr>

	<tr>
		<td class="header-small">
			{logimage} {date} {typetext}
		</td>
	</tr>
	<tr><td class="spacer"></td></tr>
	<tr>
		<td>
			{logtext}
		</td>
	</tr>
	<tr><td class="spacer"></td></tr>

	<tr>
		<td class="header-small">
		<input type="submit" name="submit" value="{t}Remove log entry{/t}" style="width:120px"/>
		</td>
	</tr>
</table>
</form>
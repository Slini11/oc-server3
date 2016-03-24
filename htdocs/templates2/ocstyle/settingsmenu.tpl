{***************************************************************************
 *  You can find the license in the docs directory
 *
 *  Unicode Reminder メモ
 ***************************************************************************}
{* OCSTYLE *}

<div class="nav4">
    <ul>
        <li class="group {if $set_profiledata}selected{/if}"><a href="myprofile.php" style="background-image: url(resource2/{$opt.template.style}/images/profile/16x16-profile.png);background-repeat:no-repeat;background-position:left center;padding-left:27px !important">{t}Personal data{/t}</a></li>
        <li class="group {if $set_publicprofile}selected{/if}"><a href="mydetails.php" style="background-image: url(resource2/{$opt.template.style}/images/profile/16x16-more-settings.png);background-repeat:no-repeat;background-position:left center;">{t}Additional information{/t}</a></li>
        <li class="group {if $set_statpic}selected{/if}"><a href="mystatpic.php" style="background-image: url(resource2/{$opt.template.style}/images/oclogo/16x16-oc_logo.png);background-repeat:no-repeat;background-position:left center;" >{t}Statistics picture{/t}</a></li>
        <li class="group {if $set_ocsettings}selected{/if}"><a href="myocsettings.php" style="background-image: url(resource2/{$opt.template.style}/images/misc/16x16-tools.png);background-repeat:no-repeat;background-position:left center;">{t}OC settings{/t}</a></li>
        <li class="group {if $set_email}selected{/if}"><a href="myemailsettings.php" style="background-image: url(resource2/{$opt.template.style}/images/profile/16x16-email.png);background-repeat:no-repeat;background-position:left center;">{t}E-mail settings{/t}</a></li>
        <li class="group {if $set_pw}selected{/if}"><a href="newpw.php" style="background-image: url(resource2/{$opt.template.style}/images/profile/16x16-security.png);background-repeat:no-repeat;background-position:left center;">{t}Change password{/t}</a></li>
    </ul>
</div>

<div style="clear:both; margin-bottom:1em">
</div>

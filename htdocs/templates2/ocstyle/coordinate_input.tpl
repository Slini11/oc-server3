{***************************************************************************
*  You can find the license in the docs directory
***************************************************************************}

<script type="text/javascript" src="resource2/ocstyle/js/coordinateInput.js"></script>

<table class="table">
  <tr class="separatedCoordInput">
    <td>
      <select name="lat_hem" {if $disabled}disabled=""{/if} {if isset($check_search)}onfocus="bydistance_set_radiobutton(2)"{/if}>
        <option value="N" {if $lat_hem == 'N'} selected {/if}>{t}N{/t}</option>
        <option value="S" {if $lat_hem == 'S'} selected {/if}>{t}S{/t}</option>
      </select>
    </td>
    <td>
      <nobr><input type="text" name="lat_deg" maxlength="2" value="{$lat_deg}" class="input30" {if $disabled}disabled=""{/if} {if isset($check_search)}onfocus="bydistance_set_radiobutton(2)"{/if}/> &deg;</nobr>
    </td>
    <td>
      <nobr><input type="text" name="lat_min" maxlength="6" value="{$lat_min}" class="input50" {if $disabled}disabled=""{/if} {if isset($check_search)}onfocus="bydistance_set_radiobutton(2)"{/if}/> '</nobr>
    </td>
    <td id="uciButton" style="display: table-cell;" rowspan="2">
      <input type="button" style="width: auto;" class="formbutton" value="&nbsp;&nbsp;{t}1 field{/t}&nbsp;&nbsp;" onclick="return unionCoordInput();" {if isset($check_search)}onfocus="bydistance_set_radiobutton(2)"{/if}/>&nbsp;
    </td>
  </tr>
  <tr class="separatedCoordInput">
    <td>
      <select name="lon_hem" {if $disabled}disabled=""{/if} {if isset($check_search)} onfocus="bydistance_set_radiobutton(2)"{/if}>
        <option value="E" {if $lon_hem == 'E'} selected {/if}>{t}E{/t}</option>
        <option value="W" {if $lon_hem == 'W'} selected {/if}>{t}W{/t}</option>
      </select>
    </td>
    <td>
      <nobr><input type="text" name="lon_deg" maxlength="3" value="{$lon_deg}" class="input30" {if $disabled}disabled=""{/if} {if isset($check_search)}onfocus="bydistance_set_radiobutton(2)"{/if}/> &deg;</nobr>
    </td>
    <td>
      <nobr><input type="text" name="lon_min" maxlength="6" value="{$lon_min}" class="input50" {if $disabled}disabled=""{/if} {if isset($check_search)}onfocus="bydistance_set_radiobutton(2)"{/if}/> '</nobr>
    </td>
  </tr>

  <tr id="unionCoordInput" style="display: none;">
    <td valign="top">
      <input type="text" tabindex="12" name="union_field" maxlength="30" value="" class="input160" {if isset($check_search)}onfocus="bydistance_set_radiobutton(2)"{/if}/>&nbsp;&nbsp;
    </td>
    <td id="sciButton">
      <input type="button" style="width: auto;" class="formbutton"  value="&nbsp;&nbsp;{t}4 fields{/t}&nbsp;&nbsp;" onclick="return separatedCoordInput();" {if isset($check_search)}onfocus="bydistance_set_radiobutton(2)"{/if}/>&nbsp;
    </td>
  </tr>

  <input type="hidden" name="lat" value="" />
  <input type="hidden" name="lon" value="" />

  {if isset($coord_error)}
  <tr>
    <td colspan="3" class="errormsg">
      {$coord_error}
    </td>
  </tr>
  {/if}

</table>

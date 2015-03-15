/* 
 *Copyright (C) 2013 Alexandre Spangaro  <alexandre.spangaro@gmail.com>
 *Copyright (C) 2015 delcroip <pmpdelcroix@gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

function regexEvent(obj,evt)
{

    //var regex= /^[0-9:]{1}$/;
    //alert(evt.charCode);
    var charCode = (evt.which) ? evt.which : evt.keyCode;

    if(((charCode >= 48) && (charCode <= 57)) || //num
          (charCode===46) || (charCode===8))// comma & periode
    {
        // ((charCode>=96) && (charCode<=105)) || //numpad
      return true;

    }else
    {
        return false;
    }
  }
//
//function valider()
//{
//    if(document.addcontract.date_start_contract_.value != "")
//    {
//        if(document.addcontract.usercontract.value != "-1") {
//            return true;
//        }else
//        {
//           alert(dol_escape_js($langs->transnoentities('InvalidUserContract')));
//           return false;
//        }
//    }else
//    {
//       alert(dol_escape_js($langs->transnoentities('NoDateStart')));
//       return false;
//    }
//}

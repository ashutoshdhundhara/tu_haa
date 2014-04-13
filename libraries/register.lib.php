<?php
/**
 * Functions required for User registration page.
 */

/**
 * Generates Html for User registration form.
 *
 * @return string $retval Form Html
 */
function HAA_getHtmlRegisterForm()
{
    $retval = '<form method="POST" action="register.php"'
        . ' class="register_form gray_grad box">'
        . '<input type="hidden" name="ajax_request" value="true">'
        . '<table>'
        . '<caption>Registration Form</caption>'
        . '<tr>'
        . '<td><label for="input_roll_no">Roll No<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_roll_no" name="roll_no"'
        . ' title="Please provide your University Roll Number"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_name">Name<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_name" name="name"'
        . ' title="Please provide your Full Name"></td>'
        . '</tr>'
        . '<td><label for="input_photo">Photo<sup class="req">*</sup> :</label></td>'
        . '<td><input type="file" class="required" id="input_photo" name="photo"'
        . ' title="Please provide your latest Passport size photograph"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_class">Class<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectClass() . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_branch">Branch<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_branch" name="branch"'
        . ' title="Please provide your Branch"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_year">Current Year<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectYear() . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_dob">Date Of Birth<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" id="input_dob" class="datefield required" name="dob"'
        . ' title="Please provide your Date Of Birth"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_category">Category<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectCategory() . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_blood">Blood Group<sup class="req">*</sup> :</label></td>'
        . '<td>' . HAA_getHtmlSelectBlood() . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_stud_mob">Student Mobile<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" id="input_stud_mob" class="mobilefield required" name="stud_mob"'
        . ' title="Please provide your Mobile number"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_email">E-mail<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_email" name="email"'
        . ' title="Please provide your valid Email address"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_father_name">Father&apos;s Name<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_father_name" name="father_name"'
        . ' title="Please provide your Father&apos;s Name (excluding Title)"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_father_mob">Father&apos;s Mobile<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" id="input_father_mob" class="mobilefield required" name="father_mobile"'
        . ' title="Please provide your Father&apos;s Mobile number"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_mother_name">Mother&apos;s Name<sup class="req">*</sup> :</label></td>'
        . '<td><input type="text" class="required" id="input_mother_name" name="mother_name"'
        . ' title="Please provide your Mother&apos;s Name (excluding Title)"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_mother_mob">Mother&apos;s Mobile :</label></td>'
        . '<td><input type="text" id="input_mother_mob" class="mobilefield" name="mother_mobile"'
        . ' title="Please provide your Mother&apos;s Mobile number"></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_addr">Permanent Address<sup class="req">*</sup> :</label></td>'
        . '<td><textarea class="required" id="input_addr" name="permanent_address"'
        . ' title="Please provide your Permanent Address"></textarea></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_alt_addr">Alternate Address :</label></td>'
        . '<td><textarea id="input_alt_addr" name="alternate_address"'
        . ' title="Please provide your Alternate Address (if any)"></textarea></td>'
        . '</tr>'
        . '<tr>'
        . '<td><label for="input_landline">Landline :</label></td>'
        . '<td><input type="text" id="input_landline" name="landline"'
        . ' title="Please provide your Home Landline number"></td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2"><input type="checkbox" id="input_agreement" name="agreement">'
        . '<label for="input_agreement">I have read all <a href="jrules.html" target="_blank">Hostel Rules &amp; Regulations</a>. I will abide by all of them failing which authorities can take punitive action.</label>'
        . '</td>'
        . '</tr>'
        . '<tr>'
        . '<td colspan="2" style="text-align: center;">'
        . '<input type="submit" name="submit" value="Register">'
        . '</td>'
        . '</tr>'
        . '</table>'
        . '</form>';

    return $retval;
}

/**
 * Generates Html for Select class list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectClass()
{
    // @todo: Classes can be saved and fetched from DB.
    $retval = '<select name="class" class="required" id="input_class"'
        .' title="Please provide your Class">'
        . '<option>...</option>'
        . '<option>BTech</option>'
        . '<option>MBA</option>'
        . '<option>MSc</option>'
        . '<option>MTech</option>'
        . '<option>MCA</option>'
        . '<option>PHD</option>'
        . '</select>';

    return $retval;
}

/**
 * Generates Html for Select year list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectYear()
{
    $retval = '<select name="current_year" class="required" id="input_year"'
        .' title="Please provide your current Year of study">'
        . '<option>...</option>';
    for ($i=1;$i<=5;$i++) {
        $retval .= '<option>' . $i . '</option>';
    }
    $retval .= '</select>';

    return $retval;
}

/**
 * Generates Html for Select category list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectCategory()
{
    $retval = '<select name="category" class="required" id="input_category"'
        .' title="Please provide your Category">'
        . '<option>...</option>'
        . '<option>GEN</option>'
        . '<option>SC</option>'
        . '<option>ST</option>'
        . '<option>BC</option>'
        . '<option>NRI</option>'
        . '</select>';

    return $retval;
}

/**
 * Generates Html for Select blood group list box.
 *
 * @return string $retval Select box
 */
function HAA_getHtmlSelectBlood()
{
    $retval = '<select name="blood_group" class="required" id="input_blood"'
        .' title="Please provide your Blood Group">'
        . '<option>...</option>'
        . '<option>A+</option>'
        . '<option>A-</option>'
        . '<option>B+</option>'
        . '<option>B-</option>'
        . '<option>O+</option>'
        . '<option>O-</option>'
        . '<option>AB+</option>'
        . '<option>AB-</option>'
        . '</select>';

    return $retval;
}
?>
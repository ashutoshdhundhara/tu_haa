<?php
/**
 * Mess voting.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';

$response = HAA_Response::getInstance();
$header = $response->getHeader();
$header->disableGlobalMessage();
$header->setTitle('Mess Voting');
$header->addFile('minified/complaint.css', 'css');

if (isset($_REQUEST['voted'])) {
    $roll_no = $_REQUEST['roll_no'];
    $passkey = $_REQUEST['pass_key'];
    $voting_response = $_REQUEST['voting_response'];
    $comments = $_REQUEST['comments'];
    $menu_items = $_REQUEST['menu_items'];

    $check_query = 'SELECT `roll_no` FROM `mess_voting` '
        . 'WHERE `roll_no` = :roll_no';
    $result = $GLOBALS['dbi']->executeQuery($check_query, array(':roll_no' => $roll_no));

    if (! preg_match('/^yes$\b|^no$/i', $voting_response)) {
        HAA_gotError('Invalid response received.');
        $response->addHTML(
            '<div class="report_complaint gray_grad box">'
            . HAA_generateErrorMessage($GLOBALS['error'])
            . '</div>'
        );
        $response->response();
        exit;
    }
    if ($result->fetch()) {
        HAA_gotError('You have already voted.');
        $response->addHTML(
            '<div class="report_complaint gray_grad box">'
            . HAA_generateErrorMessage($GLOBALS['error'])
            . '</div>'
        );
        $response->response();
        exit;
    }

    if (HAA_validateUniqueKey($roll_no, $passkey)) {
        $save_query = 'INSERT INTO `mess_voting` VALUES ('
            . ':roll_no, :voting_response, :comments, :menu_items'
            . ')';
        $query_params = array(
            ':roll_no' => $roll_no,
            ':voting_response' => $voting_response,
            ':comments' => $comments,
            ':menu_items' => $menu_items
        );

        $result = $GLOBALS['dbi']->executeQuery($save_query, $query_params);
        $response->addHTML(
            '<div class="report_complaint gray_grad box">'
            . 'Thanks for your response.'
            . '</div>'
        );
    } else {
        HAA_gotError('Invalid Roll No or PassKey.');
        $response->addHTML(
            '<div class="report_complaint gray_grad box">'
            . HAA_generateErrorMessage($GLOBALS['error'])
            . '</div>'
        );
    }

    $response->response();
    exit;
}

$retval = '<form method="POST" action="mess_voting.php"'
    . ' class="report_complaint gray_grad box" style="width: 700px">'
    . '<input type="hidden" name="voted" value="1">'
    . '<table style="width: 700px; line-height: 1.2em;">'
    . '<caption>Mess Voting</caption>'
    . '<span class="red">Last Date: 13-Aug-2014</span>'
    . '<tr>'
    . '<td colspan="2">'
    . '<input type="radio" name="voting_response" value="YES" id="input_yes">'
    . '&nbsp;&nbsp;<label for="input_yes"><strong>Yes</strong>, I am comfortable with a slight increase in price and wish to continue '
    . 'with Hostel-J\'s menu with no limit on milk products, egg items, breads, deserts etc.</label>'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td colspan="2">'
    . '<input type="radio" name="voting_response" value="NO" id="input_no">'
    . '&nbsp;&nbsp;<label for="input_no"><strong>No</strong>, I would rather go for less items on menu and limited quantity of egg items, milk products, breads, deserts etc.</label>'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td><label for="input_roll_no">Roll No<sup class="req">*</sup> :</label></td>'
    . '<td><input type="text" class="required" id="input_roll_no" name="roll_no"'
    . ' title="Please provide your University Roll Number"></td>'
    . '</tr>'
    . '<tr>'
    . '<td><label for="input_name">PassKey<sup class="req">*</sup> :</label></td>'
    . '<td><input type="text" class="required" id="input_key" name="pass_key"'
    . ' title="Please provide your Passkey available in your Web-Kiosk under Hostel Choice."></td>'
    . '</tr>'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td>'
    . 'Suggestions/Comments :'
    . '</td>'
    . '<td>'
    . '<textarea name="comments"></textarea>'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td>'
    . 'Items I would like to include in upcoming menu :'
    . '</td>'
    . '<td>'
    . '<textarea name="menu_items"></textarea>'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td colspan="2" style="text-align: center;">'
    . '<input type="submit" name="submit" value="Submit">'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td colspan="2">'
    . '<strong>Note: </strong>'
    . 'The majority votes would decide what Hostel J\'s mess would offer you during this semester under the new mess committee, A lavish menu or a limited quantity of items like other hostels. '
    . '</td>'
    . '</tr>'
    . '</table>'
    . '</form>';

$response->addHTML($retval);
$response->response();

?>
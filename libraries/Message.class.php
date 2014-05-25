<?php
/**
 * Class to display all type of messages.
 */

class HAA_Message
{
    public function __construct() {

    }

    /**
     * Generates success message.
     *
     * @param  string $message Message to display
     *
     * @return string          Html
     */
    public static function success($message = '') {
        $msg = '<div class="ui-widget">'
            . '<div class="ui-state-highlight ui-corner-all" '
            . 'style="margin-top: 20px; padding: 1em; font-size: 0.8em; '
            . 'display: inline-block;">'
            . '<p><span class="ui-icon ui-icon-info" style="float: left; '
            . 'margin-right: .3em;"></span>'
            . '<strong>' . 'SUCCESS: ' . '</strong>'
            . $message
            . '</p>'
            . '</div>'
            . '</div>';

        return $msg;
    }

    /**
     * Generates error message.
     *
     * @param  string $message Message to display
     *
     * @return string          Html
     */
    public static function error($message = '') {
        $msg = '<div class="ui-widget">'
            . '<div class="ui-state-error ui-corner-all" '
            . 'style="margin-top: 20px; padding: 1em; font-size: 0.8em; '
            . 'display: inline-block;">'
            . '<p><span class="ui-icon ui-icon-alert" style="float: left; '
            . 'margin-right: .3em;"></span>'
            . '<strong>' . 'ERROR: ' . '</strong>'
            . $message
            . '</p>'
            . '</div>'
            . '</div>';

        return $msg;
    }

    /**
     * Generates notice message.
     *
     * @param  string $message Message to display
     *
     * @return string          Html
     */
    public static function notice($message = '') {
        $msg = '<div class="ui-widget">'
            . '<div class="ui-state-highlight ui-corner-all" '
            . 'style="margin-top: 20px; padding: 1em; font-size: 0.8em; '
            . 'display: inline-block;">'
            . '<p><span class="ui-icon ui-icon-info" style="float: left; '
            . 'margin-right: .3em;"></span>'
            . '<strong>' . 'NOTICE: ' . '</strong>'
            . $message
            . '</p>'
            . '</div>'
            . '</div>';

        return $msg;
    }
}
?>
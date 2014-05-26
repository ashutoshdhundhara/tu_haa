<?php
/**
 * Manages the Header on every page.
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Class used to output the HTML headers
 */
class HAA_Header
{
    /**
     * Whether to display anything.
     *
     * @access private
     * @var bool
     */
    private $_isEnabled;
    /**
     * Array containing names of Javascripts to be included.
     *
     * @access private
     * @var array
     */
    private $_scripts;
    /**
     * Array containing names of Stylesheets to be included.
     *
     * @access private
     * @var array
     */
    private $_stylesheets;
    /**
     * Variable containing Title of the page.
     *
     * @access private
     * @var string
     */
    private $_title;
    /**
     * The value for the id attribute for the body tag
     *
     * @access private
     * @var string
     */
    private $_bodyId;
    /**
     * Whether to display global message box or not.
     *
     * @access private
     * @var bool
     */
    private $_displayGlobalMessage;

    /**
     * Creates a new class instance.
     */
    public function __construct()
    {
        $this->_isEnabled = true;
        $this->_displayGlobalMessage = true;
        $this->_title = ' | Hostel-J';
        $this->_scripts = array();
        $this->_scripts = array();
        $this->_addDefaultFiles();
    }

    /**
     * Loads common scripts and stylesheets.
     *
     * @return void
     */
    private function _addDefaultFiles()
    {
        $default_scripts = array(
            '/minified/common.js'
            );
        foreach ($default_scripts as $key => $filename) {
            $this->addFile($filename, 'js');
        }

        $default_stylesheets = array(
            'minified/reset.css',
            'minified/absolution.css',
            'minified/common.css'
            );
        foreach ($default_stylesheets as $key => $filename) {
            $this->addFile($filename, 'css');
        }
    }

    /**
     * Sets Title of the page.
     *
     * @param string
     *
     * @return void
     */
    public function setTitle($title)
    {
        $this->_title = htmlspecialchars($title) . $this->_title;
    }

     /**
     * Setter for the ID attribute in the BODY tag
     *
     * @param string $id Value for the ID attribute
     *
     * @return void
     */
    public function setBodyId($id)
    {
        $this->_bodyId = htmlspecialchars($id);
    }

    /**
     * Adds a Javascript/Stylesheet file to page.
     *
     * @param string filename
     * @param string file type
     *
     * @return void
     */
    public function addFile($filename, $type)
    {
        $hash = md5($filename);
        switch ($type) {
            case 'js':
                if (! isset($this->_scripts[$hash])) {
                    $this->_scripts[$hash] = $filename;
                }
                break;
            case 'css':
                if (! isset($this->_stylesheets[$hash])) {
                    $this->_stylesheets[$hash] = $filename;
                }
                break;
        }
    }

    /**
     * Returns the DOCTYPE and the start HTML tag
     *
     * @return string DOCTYPE and HTML tags
     */
    private function _getHtmlStart()
    {
        $retval  = "<!DOCTYPE HTML>";
        $retval .= "<html lang='en' >";

        return $retval;
    }

    /**
     * Returns the META tags
     *
     * @return string the META tags
     */
    private function _getMetaTags()
    {
        $retval  = '<meta http-equiv="Content-Type" content="text/html;'
            . ' charset=UTF-8">';

        return $retval;
    }

    /**
     * Returns the LINK tags for the favicon and the stylesheets
     *
     * @return string the LINK tags
     */
    private function _getLinkTags()
    {
        $retval = '<link rel="icon" href="favicon.ico" '
            . 'type="image/x-icon" />'
            . '<link rel="shortcut icon" href="favicon.ico" '
            . 'type="image/x-icon" />'
            . '<link rel="stylesheet" '
            . 'href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/redmond/jquery-ui.css" />';
        // Stylesheets
        $separator = '&stylesheets[]=';
        $url = 'css/get_stylesheets.php'
            . '?stylesheets[]='
            . implode($separator, $this->_stylesheets);
        $link = sprintf(
            '<link rel="stylesheet" type="text/css" href="%s" >',
            htmlspecialchars($url)
        );

        $retval .= $link;

        return $retval;
    }

    /**
     * Returns the TITLE tag
     *
     * @return string the TITLE tag
     */
    private function _getTitleTag()
    {
        $retval  = "<title>";
        $retval .= $this->_getPageTitle();
        $retval .= "</title>";
        return $retval;
    }

    /**
     * If the page is missing the title, this function
     * will set it to something reasonable
     *
     * @return string
     */
    private function _getPageTitle()
    {
        if (empty($this->_title)) {
            $this->_title = 'Hostel-J';
        }

        return $this->_title;
    }

    /**
     * Returns the SCRIPT tag.
     *
     * @return string SCRIPT tag.
     */
    private function _getScriptTag()
    {
        $script_tag = '<script type="text/javascript" '
            . 'src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>';
        $script_tag .= '<script type="text/javascript" '
            . 'src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>';
        $separator = '&scripts[]=';
        $url = 'js/get_scripts.php'
            . '?scripts[]='
            . implode($separator, $this->_scripts);

        $script_tag .= sprintf(
            '<script type="text/javascript" src="%s"></script>',
            htmlspecialchars($url)
        );

        return $script_tag;
    }

    /**
     * Returns the close tag to the HEAD
     * and the start tag for the BODY
     *
     * @return string HEAD and BODY tags
     */
    private function _getBodyStart()
    {
        $retval = "</head><body";
        if (! empty($this->_bodyId)) {
            $retval .= " id='" . $this->_bodyId . "'";
        }
        $retval .= ">";

        return $retval;
    }

    /**
     * Returns body header part. (i.e. Heading etc.)
     *
     * @return string Body Header.
     */
    private function _getBodyHeader()
    {
        $retval = '';
        $retval .= '<header class="green_grad"><table><tr>'
            . '<td class="td_small"><a href="index.php">'
            . '<img height="80" width="100" src="img/jlogo.png" alt="Hostel-J Logo"/>'
            . '</a></td>'
            . '<td class="td_big"><h1>Hostel-J, Thapar University</h1></td>'
            . '<td class="td_small"><a href="http://thapar.edu" target="_BLANK">'
            . '<img height="100" width="160" src="img/tulogo.png" alt="Thapar Logo"/>'
            . '</a></td>'
            . '</tr></table></header>';
        $retval .= $this->_getLoginDetails();
        $retval .= $this->_getGlobalMessage();
        $retval .= '<div class="body_area">';
        $retval .= '<div class="body_content">';

        return $retval;
    }

    /**
     * Returns Login details box, if available
     *
     * @return string Login box
     */
    private function _getLoginDetails()
    {
        $retval = '';
        if (isset($_SESSION['login_id'])) {
            $retval .= '<div class="login_details">'
                . 'Login ID : '
                . '<strong> ' . $_SESSION['login_id'] . ' </strong>'
                . '<a href="logout.php" class="blue"> Logout</a>'
                . '</div>';
        }

        return $retval;
    }

    /**
     * Returns global message box, if any message to display
     *
     * @return string Html
     */
    private function _getGlobalMessage()
    {
        $retval = '';
        if (HAA_checkToDisplayGlobalMessage() && $this->_displayGlobalMessage) {
            $allotment_status = HAA_getAllotmentProcessStatus();
            $message = $allotment_status['message'];
            $retval .= '<div class="global_message">'
                . HAA_Message::notice($message)
                . '</div>';
        }

        return $retval;
    }

    /**
     * Disables the rendering of the header.
     *
     * @return void
     */
    public function disable()
    {
        $this->_isEnabled = false;
    }

    /**
     * Disables global message box.
     *
     * @return void
     */
    public function disableGlobalMessage()
    {
        $this->_displayGlobalMessage = false;
    }

    /**
     * Generates the header
     *
     * @return string The header
     */
    public function getHeader()
    {
        $retval = '';
        if ($this->_isEnabled) {
            $retval .= $this->_getHtmlStart();
            $retval .= $this->_getMetaTags();
            $retval .= $this->_getLinkTags();
            $retval .= $this->_getTitleTag();
            $retval .= $this->_getScriptTag();
            $retval .= $this->_getBodyStart();
            $retval .= $this->_getBodyHeader();
        }

        return $retval;
    }
}

?>
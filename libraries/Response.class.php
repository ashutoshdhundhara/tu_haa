<?php
/**
 * Manages the page content to be sent to the client.
 */

if (! defined('TU_HAA')) {
    exit;
}

require_once 'libraries/Header.class.php';
require_once 'libraries/Footer.class.php';

/**
 * Class to manage the responses to be sent to the client.
 */
class HAA_Response
{
    /**
     * HAA_Response instance
     *
     * @access private
     * @static
     * @var HAA_Response
     */
    private static $_instance;
    /**
     * HAA_Header instance
     *
     * @access private
     * @var HAA_Header
     */
    private $_header;
    /**
     * Html data to be sent in response
     *
     * @access private
     * @var string
     */
    private $_HTML;
    /**
     * An array of JSON key-value pairs
     * to be sent back for ajax requests
     *
     * @access private
     * @var array
     */
    private $_JSON;
    /**
     * HAA_Footer instance
     *
     * @access private
     * @var HAA_Footer
     */
    private $_footer;
    /**
     * Whether we are servicing an ajax request.
     *
     * @access private
     * @var bool
     */
    private $_isAjax;
    /**
     * Whether there were any errors druing the processing of the request
     * Only used for ajax responses
     *
     * @access private
     * @var bool
     */
    private $_isSuccess;

    /**
     * Creates a new class instance
     */
    private function __construct()
    {
        $this->_header = new HAA_Header();
        $this->_HTML   = '';
        $this->_JSON   = array();
        $this->_footer = new HAA_Footer();
        $this->_isAjax     = false;
        $this->_isSuccess  = true;

        if (isset($_REQUEST['ajax_request']) && $_REQUEST['ajax_request'] == true) {
            $this->_isAjax = true;
        }
    }

    /**
     * Returns the singleton HAA_Response object.
     *
     * @return HAA_Response object
     */
    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new HAA_Response();
        }
        return self::$_instance;
    }

    /**
     * Disables the rendering of the header
     * and the footer in responses
     *
     * @return void
     */
    public function disable()
    {
        $this->_header->disable();
        $this->_footer->disable();
    }

    /**
     * Returns a HAA_Header object
     *
     * @return HAA_Header
     */
    public function getHeader()
    {
        return $this->_header;
    }

    /**
     * Returns a HAA_Footer object
     *
     * @return HAA_Footer
     */
    public function getFooter()
    {
        return $this->_footer;
    }

    /**
     * Add HTML code to the response
     *
     * @param string $content A string to be appended to response.
     *
     * @return void
     */
    public function addHTML($content)
    {
        if (is_array($content)) {
            foreach ($content as $msg) {
                $this->addHTML($msg);
            }
        } else {
            $this->_HTML .= $content;
        }
    }

    /**
     * Add JSON code to the response
     *
     * @param mixed $json  Either a key (string) or an
     *                     array or key-value pairs
     *
     * @return void
     */
    public function addJSON($json, $value = null)
    {
        if (is_array($json)) {
            foreach ($json as $key => $value) {
                $this->addJSON($key, $value);
            }
        } else {
            $this->_JSON[$json] = $value;
        }
    }

    /**
     * Renders the HTML response text
     *
     * @return void
     */
    private function _getHtmlResponse()
    {
        $retval  = $this->_header->getHeader();
        $retval .= $this->_HTML;
        $retval .= $this->_footer->getFooter();

        echo $retval;
    }

    /**
     * Sends a JSON response to the browser
     *
     * @return void
     */
    private function _getAjaxResponse()
    {
        $this->disable();
        // $this->_JSON['message'] = $this->_getHtmlResponse();
        $this->_JSON['success'] = $this->_isSuccess;
        /*Set the Content-Type header to JSON so that jQuery parses the
        response correctly.*/
        header('Cache-Control: no-cache');
        header('Content-Type: application/json');

        echo json_encode($this->_JSON);
    }

    /**
     * Sends an HTML response to the browser
     *
     * @static
     * @return void
     */
    public static function response()
    {
        $response = HAA_Response::getInstance();
        if ($response->_isAjax) {
            $response->_getAjaxResponse();
        } else {
            $response->_getHtmlResponse();
        }
        exit;
    }
}
?>
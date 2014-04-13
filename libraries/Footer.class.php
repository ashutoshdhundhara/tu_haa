<?php
/**
 * Manages the footer on every page.
 */

if (! defined('TU_HAA')) {
    exit;
}

/**
 * Class used to output the page Footer.
 */
class HAA_Footer
{
    /**
     * Whether to display anything
     *
     * @access private
     * @var bool
     */
    private $_isEnabled;

    public function __construct()
    {
        $this->_isEnabled = true;
    }

    /**
     * Disables the rendering of the footer.
     *
     * @return void
     */
    public function disable()
    {
        $this->_isEnabled = false;
    }

    /**
     * Generates the footer.
     *
     * @return string The footer
     */
    public function getFooter()
    {
        $retval = '';
        if ($this->_isEnabled) {
            $retval .= '</div></div>'
                . '<footer class="green_grad">'
                . '<ul>'
                . '<li><a href="#">Rules & Regulations</a></li>'
                . '<li class="separator">|</li>'
                . '<li><a href="#">Report Issue</a></li>'
                . '<li class="separator">|</li>'
                . '<li><a href="#">Contact Us</a></li>'
                . '<li class="separator">|</li>'
                . '<li><a href="#">Developers</a></li>'
                . '</ul>'
                . '</footer>'
                . '</body></html>';
        }

        return $retval;
    }
}
?>
<?php
/**
 * @package   OSHider
 * @contact   www.alledia.com, support@alledia.com
 * @copyright 2015 Alledia.com, All rights reserved
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @fork      Most of the code is forked from http://dioscouri.com/joomla-extensions/non-commercial-extensions/hider
 */

use Alledia\Framework\Joomla\Extension\AbstractPlugin;

defined('_JEXEC') or die();

require_once 'include.php';

/**
 * OSHider Content Plugin
 *
 */
class PlgContentOSHider extends AbstractPlugin
{
    /**
     * @var string
     */
    protected $namespace = 'OSHider';

    /**
     * @param JEventDispatcher $subject
     * @param array            $config
     */
    public function __construct($subject, $config = array())
    {
        parent::__construct($subject, $config);

        $this->loadLanguage();

    }

    /**
     *
     * @param unknown_type $context
     * @param unknown_type $article
     * @param unknown_type $params
     * @param unknown_type $page
     */
    public function onContentPrepare($context, $article, $params, $page = 0)
    {
        return $this->doContentPrepare($context, $article, $params, $page);
    }

    /**
     *
     * @param unknown_type $context
     * @param unknown_type $row
     * @param unknown_type $params
     * @param unknown_type $page
     *
     * @return boolean
     */
    private function doContentPrepare($context, $row, $params, $page = 0)
    {
        $success = true;

        // define the regular expression
        $regex1 = "#{reg}(.*?){/reg}#s";
        $regex2 = "#{pub}(.*?){/pub}#s";

        $regex3 = "#{author}(.*?){/author}#s";
        $regex4 = "#{editor}(.*?){/editor}#s";
        $regex5 = "#{publisher}(.*?){/publisher}#s";
        $regex6 = "#{manager}(.*?){/manager}#s";
        $regex7 = "#{admin}(.*?){/admin}#s";
        $regex8 = "#{super}(.*?){/super}#s";

        $regex9  = "#\{19}(.*?){/19}#s";
        $regex10 = "#\{20}(.*?){/20}#s";
        $regex11 = "#\{21}(.*?){/21}#s";
        $regex12 = "#\{23}(.*?){/23}#s";
        $regex13 = "#\{24}(.*?){/24}#s";
        $regex14 = "#\{25}(.*?){/25}#s";

        // added for user replacement
        $regex15 = "#{user:(.*?)}(.*?){/user}#s";

        // added for special replacement
        $regex16 = "#{special}(.*?){/special}#s";

        // added to support 1/more groups, in CSV format of lowercase group names
        $regex17 = "#{groups:(.*?)}(.*?){/groups}#s";

        // perform the replacement for _reg
        $row->text = preg_replace_callback($regex1, array($this, 'reg'), $row->text);
        // perform the replacement for _pub
        $row->text = preg_replace_callback($regex2, array($this, 'pub'), $row->text);

        // perform the replacement for groups by name
        $row->text = preg_replace_callback($regex3, array($this, 'author'), $row->text);
        $row->text = preg_replace_callback($regex4, array($this, 'editor'), $row->text);
        $row->text = preg_replace_callback($regex5, array($this, 'publisher'), $row->text);
        $row->text = preg_replace_callback($regex6, array($this, 'manager'), $row->text);
        $row->text = preg_replace_callback($regex7, array($this, 'admin'), $row->text);
        $row->text = preg_replace_callback($regex8, array($this, 'super'), $row->text);

        // perform the replacement for groups by gid
        $row->text = preg_replace_callback($regex9, array($this, 'author'), $row->text);
        $row->text = preg_replace_callback($regex10, array($this, 'editor'), $row->text);
        $row->text = preg_replace_callback($regex11, array($this, 'publisher'), $row->text);
        $row->text = preg_replace_callback($regex12, array($this, 'manager'), $row->text);
        $row->text = preg_replace_callback($regex13, array($this, 'admin'), $row->text);
        $row->text = preg_replace_callback($regex14, array($this, 'super'), $row->text);

        // perform the replacement for user
        $row->text = preg_replace_callback($regex15, array($this, 'user'), $row->text);

        // perform the replacement for special
        $row->text = preg_replace_callback($regex16, array($this, 'special'), $row->text);

        // perform the replacement for groups
        $row->text = preg_replace_callback($regex17, array($this, 'groups'), $row->text);

        return $success;
    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return Ambigous <string, unknown>
     */
    private function reg($matches)
    {
        $user   = JFactory::getUser();
        $return = '';

        if (!empty($user->id)) {
            $return = $matches[1];
        }

        return $return;
    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return Ambigous <string, unknown>
     */
    private function pub($matches)
    {

        $user   = JFactory::getUser();
        $return = $matches[1];

        if (!empty($user->id)) {
            $return = '';
        }

        return $return;
    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return Ambigous <string, unknown>
     */
    private function author($matches)
    {

        $user_groups = $this->getUserGroups();

        $return = '';
        if (in_array('author', $user_groups->group_names)) {
            $return = $matches[1];
        }

        return $return;
    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return Ambigous <string, unknown>
     */
    private function editor($matches)
    {

        $user_groups = $this->getUserGroups();

        $return = '';
        if (in_array('editor', $user_groups->group_names)) {
            $return = $matches[1];
        }

        return $return;
    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return Ambigous <string, unknown>
     */
    private function publisher($matches)
    {

        $user_groups = $this->getUserGroups();

        $return = '';
        if (in_array('publisher', $user_groups->group_names)) {
            $return = $matches[1];
        }

        return $return;
    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return Ambigous <string, unknown>
     */
    private function manager($matches)
    {

        $user_groups = $this->getUserGroups();

        $return = '';
        if (in_array('manager', $user_groups->group_names)) {
            $return = $matches[1];
        }

        return $return;
    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return unknown
     */
    private function admin($matches)
    {

        $user_groups = $this->getUserGroups();

        $return = '';
        if (in_array('administrator', $user_groups->group_names)) {
            $return = $matches[1];
        }

        return $return;
    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return Ambigous <string, unknown>
     */
    private function super($matches)
    {

        $needles = array('super administrator', 'super users');

        $user_groups = $this->getUserGroups();

        $return = '';
        foreach ($needles as $needle) {
            if (in_array($needle, $user_groups->group_names)) {
                $return = $matches[1];
            }
        }
        return $return;
    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return Ambigous <string, unknown>
     */
    private function special($matches)
    {

        $needles = array(
            'super administrator',
            'super users',
            'author',
            'editor',
            'publisher',
            'manager',
            'administrator'
        );

        $user_groups = $this->getUserGroups();

        $return = '';
        foreach ($needles as $needle) {
            if (in_array($needle, $user_groups->group_names)) {
                $return = $matches[1];
            }
        }
        return $return;

    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return Ambigous <string, unknown>
     */
    private function user($matches)
    {

        $user      = JFactory::getUser();
        $userid    = $user->get('id');
        $username  = $user->get('username');
        $useremail = $user->get('email');

        $match = $matches[1];

        $return = '';

        if (($match == $username) || ($match == $useremail) || ($match == strval($userid))) {
            $return = $matches[2];
        }

        return $return;
    }

    /**
     *
     * @param unknown_type $matches
     *
     * @return Ambigous <string, unknown>
     */
    private function groups($matches)
    {

        $match = $matches[1];
        // explode $match by ,
        $allowed_groups = explode(',', $match);
        foreach ($allowed_groups as $key => $allowed_group) {
            $allowed_groups[$key] = strtolower(trim($allowed_group));
            if (empty($allowed_groups[$key])) {
                unset($allowed_groups[$key]);
            }
        }

        $user_groups = $this->getUserGroups();

        $return = '';
        // if the user is in any of the groups in $allowed_groups, grant access to $match[2]
        foreach ($allowed_groups as $allowed_group) {
            if (in_array($allowed_group, $user_groups->group_ids) || in_array(
                    $allowed_group,
                    $user_groups->group_names
                )
            ) {
                $return = $matches[2];
                return $return;
            }
        }

        return $return;
    }

    private function getUserGroups()
    {
        // get all of the current user's groups
        $user              = JFactory::getUser();
        $user_groups       = array();
        $authorized_groups = array();

        $authorized_groups = $user->getAuthorisedGroups();

        foreach ($authorized_groups as $authorized_group) {
            $table = JTable::getInstance('Usergroup', 'JTable');
            $table->load($authorized_group);
            $user_groups[$authorized_group] = strtolower($table->title);
        }

        $return              = new stdClass();
        $return->group_names = $user_groups;
        $return->group_ids   = $authorized_groups;

        return $return;
    }
}
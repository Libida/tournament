<?php
/**
 * Service class for Twitter support
 * 
 * PHP version 5.2
 *
 * The contents of this file are subject to the Mozilla Public License
 * Version 1.1 (the "License"); you may not use this file except in
 * compliance with the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS"
 * basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 * License for the specific language governing rights and limitations
 * under the License.
 *
 * @category  phpMyFAQ
 * @package   PMF_Services
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2010-2011 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2010-09-05
 */

/**
 * PMF_Services_Twitter
 * 
 * @category  phpMyFAQ
 * @package   PMF_Services
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2010-2011 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2010-09-05
 */
class PMF_Services_Twitter extends PMF_Services
{
    /**
     * @var TwitterOAuth
     */
    protected $connection = null;

    /**
     * Constructor
     * 
     * @param TwitterOAuth $connection
     *
     * @return PMF_Services_Twitter
     */
    public function __construct(TwitterOAuth $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Adds a post to Twitter
     * 
     * @param string $question Question
     * @param string $tags     String of tags
     * @param string $link     URL to FAQ
     * 
     * @return void
     */
    public function addPost($question, $tags, $link)
    {
        $hashtags = '';
        
        if ($tags != '') {
            $hashtags = '#' . str_replace(',', ' #', $tags);
        }

        $message  = PMF_String::htmlspecialchars($question);
        $message .= ' ' . $hashtags;
        $message .= ' ' . $link;

        $this->connection->post('statuses/update', array('status' => $message));
    }
}
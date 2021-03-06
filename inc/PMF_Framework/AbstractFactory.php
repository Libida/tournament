<?php
/**
 * Abstract Factory for phpMyFAQ Framework
 *
 * PHP Version 5.2
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
 * @package   PMF_Framework
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2011 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2011-09-30
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    exit();
}

/**
 * PMF_Framework_AbstractFactory
 * 
 * @category  phpMyFAQ
 * @package   PMF_Framework
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2011 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/MPL-1.1.html Mozilla Public License Version 1.1
 * @link      http://www.phpmyfaq.de
 * @since     2011-09-30
 */
abstract class PMF_Framework_AbstractFactory
{
    /**
     * @abstract
     * @param PMF_Framework_ControllerInterface $controller
     * @return void
     */
    abstract public function getController(PMF_Framework_ControllerInterface $controller);

    /**
     * @abstract
     * @param PMF_Framework_ViewInterface $view
     * @return void
     */
    abstract public function getView(PMF_Framework_ViewInterface $view);
}
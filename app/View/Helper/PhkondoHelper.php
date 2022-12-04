<?php

/**
 *
 * pHKondo : pHKondo software for condominium property managers (https://www.phalkaline.net)
 * Copyright (c) pHAlkaline . (https://www.phalkaline.net)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 * @copyright     Copyright (c) pHAlkaline . (https://www.phalkaline.net)
 * @link          https://phkondo.net pHKondo Project
 * @package       app.Model
 * @since         pHKondo v 1.1.1
 * @license       http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 *
 */
App::uses('AppHelper', 'View/Helper');

class PhkondoHelper extends AppHelper {

    private $_hasFiscalYear = null;
    var $helpers = array('Session');

    public function hasFiscalYear($condo_id='') {
        if ($this->_hasFiscalYear !== null) {
            return $this->_hasFiscalYear;
        }
        if ($condo_id == '') {
            $this->_hasFiscalYear = false;
        } else {
            App::import("Model", "FiscalYear");
            $fiscalYear = new FiscalYear();
            $fiscalYearResult=$fiscalYear->find("first",array('FiscalYear.active'=>1,'FiscalYear.condo_id'=>$condo_id));
            if (count($fiscalYearResult)){
                $this->_hasFiscalYear = true;
            }
        }
        return $this->_hasFiscalYear;
    }

}

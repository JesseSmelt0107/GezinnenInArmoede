<?php

namespace ccmslibcustom\items\IntermediairCheckForm;

use Item;
use xajax;
use ccmslib\ManagerViews\ItemManagerView\ItemManagerView;
use ccmslib\items\Item\ItemView;

class IntermediairCheckFormView extends ItemView {
    /*
     * constructor voor myItem
     *
     * @param item $item
     * @param String $titel
     * @param String $template
     */

    public function __construct(xajax $xajax, ItemManagerView $imv) {
        parent::__construct($xajax, $imv);
        $this->itemclass = 'ccmslibcustom\\items\\IntermediairCheckForm\\IntermediairCheckForm';
    }

    /**
     * haal element waar item mag weer
     *
     * @return unknown
     */
    static function getContainerElement() {
        return array('Items');
    }

    /**
     * alle containers ophalen van dit item
     *
     * @return unknown
     */
    static function getContainersElements() {
        $elements = array();
        return $elements;
    }

}
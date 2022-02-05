<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot',]));
     ?><div class="comp_slot">
    <span><?php 
    if (!empty($this->slots["default"])) {
    foreach ($this->slots['default'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    } ?></span>
</div><?php 
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b16042'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><p>xjd</p><?php 
};
Parsed::$templates['slot_default?id=61fede1b16091'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?>
        djdh
        <?php 
};
Parsed::$templates['comp/simple'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><div class="comp/simple">
    comp/simple
</div><?php 
};
Parsed::$templates['slot_default?id=61fede1b160b4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this',]));
      $this->comp[0] = Parsed::template('comp/simple', []);

    $this->comp[0]->render($this->data);  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b16077'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slot','_attrs','slots',]));
      
    if (!empty($this->slots["sn9"])) {
    foreach ($this->slots['sn9'] as $slot) {
    $slot->render(array_merge($this->data, []));
    }
    }
    else  {
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b16091", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    $this->comp[0] = Parsed::template("slot_default?id=61fede1b160b4", $_attrs);
    $this->comp[0]->setSlots($slots);
    $this->comp[0]->render($this->data);
    }  
};
Parsed::$templates['comp/comp_slot_slot_default?id=61fede1b1624e'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><p>hdhd</p><?php 
};
Parsed::$templates['comp/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slots',]));
      $this->comp[0] = Parsed::template('comp/comp_slot', []);
$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b16042', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b16077', []));

    $this->comp[1]->setSlots($slots);$this->comp[1] = $this->comp[0]->addSlot('default', Parsed::template('comp/comp_slot_slot_default?id=61fede1b1624e', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data);  
};
Parsed::$templates['comp/a_slot_sn9?id=61fede1b162d4'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip([]));
     ?><p>9</p><?php 
};
Parsed::$templates['./cases/a'] = function ($data, $slots) {
    extract($this->data); $_attrs = array_diff_key($this->attrs, array_flip(['this','slots',]));
     ?><!DOCTYPE html>
<html>
<body><?php $this->comp[0] = Parsed::template('comp/a', []);
$this->comp[1] = $this->comp[0]->addSlot('sn9', Parsed::template('comp/a_slot_sn9?id=61fede1b162d4', []));

    $this->comp[1]->setSlots($slots);
    $this->comp[0]->render($this->data); ?>

-----</body></html><?php 
};
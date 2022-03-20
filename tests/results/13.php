<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['comp/simple'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp/simple">
    comp/simple
</div>

 <?php };
Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp_slot">
    <span>
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></span>
</div>

 <?php };
Parsed::$templates['sn5?slot=default&id=2'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData);  };
Parsed::$templates['sn6?slot=default&id=3'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  foreach ($this->slots("sn7") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  };
Parsed::$templates['comp/comp_slot?slot=default&id=4'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="x">
        
<?php foreach ($this->slots("sn8") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("sn8"))) {  $this->comp[1] = Parsed::template("comp/simple", []);  $this->comp[1]->render($this->scopeData);  } ?>
    </div> <?php };
Parsed::$templates['comp/comp_slot?slot=default&id=5'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <p>xjd</p> <?php };
Parsed::$templates['sn9?slot=default&id=6'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> 
        djdh
         <?php };
Parsed::$templates['sn9?slot=default&id=7'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("comp/simple", []);  $this->comp[0]->render($this->scopeData);  };
Parsed::$templates['comp/comp_slot?slot=default&id=8'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <p>hdhd</p> <?php };
Parsed::$templates['comp/cns'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="sdefsdef">
    
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("default"))) { ?><span>
<?php foreach ($this->slots("sn") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></span>
<?php } ?>
</div>


<div class="sdefsdef">
    
<?php foreach ($this->slots("sn1") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("sn1"))) { ?><span>
<?php foreach ($this->slots("sn2") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("sn2"))) { ?>foo
<?php } ?></span>
<?php } ?>
</div>


<div class="sdefsdef">
    
<?php foreach ($this->slots("sn3") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("sn3"))) { ?><span>
<?php foreach ($this->slots("sn4") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
}  if (empty($this->slots("sn4"))) {  $this->comp[1] = Parsed::template("comp/simple", []);  $this->comp[1]->render($this->scopeData);  } ?></span>
<?php } ?>
</div>


<?php $this->comp[0] = Parsed::template("comp/comp_slot", []);  foreach ($this->slots("sn5") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}  if (empty($this->slots("sn5"))) { ;  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("sn5?slot=default&id=2", []));  }  $this->comp[0]->render($this->scopeData);  $this->comp[0] = Parsed::template("comp/comp_slot", []);  foreach ($this->slots("sn6") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}  if (empty($this->slots("sn6"))) { ;  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("sn6?slot=default&id=3", []));  }  $this->comp[0]->render($this->scopeData);  $this->comp[0] = Parsed::template("comp/comp_slot", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=4", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData);  $this->comp[0] = Parsed::template("comp/comp_slot", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=5", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  foreach ([1] as $a) {   foreach ($this->slots("sn9") as $_slot) {
$this->comp[0]->addSlot("default", $_slot);
}  if (empty($this->slots("sn9"))) { ;  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("sn9?slot=default&id=6", []));  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("sn9?slot=default&id=7", []));  }  }   $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("comp/comp_slot?slot=default&id=8", ['slot' => 'default', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData);  };
Parsed::$templates['comp/cns?slot=sn&id=9'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <span class="x"></span> <?php };
Parsed::$templates['comp/cns?slot=sn1&id=10'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <span class="y"></span> <?php };
Parsed::$templates['comp/cns?slot=sn3&id=11'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <p>3</p> <?php };
Parsed::$templates['comp/cns?slot=sn8&id=12'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <span>8</span> <?php };
Parsed::$templates['comp/cns?slot=sn9&id=13'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <p>9</p> <?php };
Parsed::$templates['./temp/13'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("comp/cns", []);  for ($i=0;$i<2;$i++) {   $this->comp[1] = $this->comp[0]->addSlot("sn", Parsed::template("comp/cns?slot=sn&id=9", ['slot' => 'sn', '_index' => '0'])->setSlots($this->slots));  }   $this->comp[1] = $this->comp[0]->addSlot("sn1", Parsed::template("comp/cns?slot=sn1&id=10", ['slot' => 'sn1', '_index' => '0'])->setSlots($this->slots));  $this->comp[1] = $this->comp[0]->addSlot("sn3", Parsed::template("comp/cns?slot=sn3&id=11", ['slot' => 'sn3', '_index' => '0'])->setSlots($this->slots));  $this->comp[1] = $this->comp[0]->addSlot("sn5", Parsed::template("comp/simple", []));  $this->comp[1] = $this->comp[0]->addSlot("sn8", Parsed::template("comp/cns?slot=sn8&id=12", ['slot' => 'sn8', '_index' => '0'])->setSlots($this->slots));  $this->comp[1] = $this->comp[0]->addSlot("sn9", Parsed::template("comp/cns?slot=sn9&id=13", ['slot' => 'sn9', '_index' => '0'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>

-----

 <?php };
<?php 
use PhpTemplates\Parsed;
use PhpTemplates\DomEvent;
use PhpTemplates\Helper;

Parsed::$templates['comp/comp_slot'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <div class="comp_slot">
    <span>
<?php foreach ($this->slots("default") as $_slot) {
$_slot->render(array_merge($this->scopeData, []));
} ?></span>
</div>

 <?php };
Parsed::$templates['b1?slot=1'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data); ?> <b11>123</b11> <?php };
Parsed::$templates['./temp/1'] = function ($data, $slots) {
$this->attrs = $this->data;
extract($data);  $this->comp[0] = Parsed::template("comp/comp_slot", []);  $this->comp[1] = $this->comp[0]->addSlot("default", Parsed::template("***block", [])->withName("b1")->setSlots($this->slots));  $this->comp[2] = $this->comp[1]->addSlot("b1", Parsed::template("b1?slot=1", ['_index' => '1'])->setSlots($this->slots));  $this->comp[0]->render($this->scopeData); ?>

-----

 <?php };
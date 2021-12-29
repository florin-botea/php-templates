<?php 
use DomDocument\PhpTemplates\Parsed;
use DomDocument\PhpTemplates\DomEvent;
Parsed::$templates['layouts/app'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><!DOCTYPE html>
<html>
    <head>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    </head>
    
    <body>
        <?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
    </body>
</html><?php 
};
Parsed::$templates['components/helper'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data',])));
     ?><i class="fas fa-question-circle"></i><?php 
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?><?php 
};
Parsed::$templates['components/helper_slot_default_61cc4f0b6951f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>h<?php 
};
Parsed::$templates['slot_default_61cc4f0b696d2'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>Slot with default as comp<?php 
};
Parsed::$templates['slot_default_61cc4f0b69e9b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['title',])));
     ?><h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5><?php 
};
Parsed::$templates['components/card'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp',])));
     ?><div class="card">
    <div class="card-body">
        <?php 
    if (!empty($slots["title"])) {
    foreach ($slots['title'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc4f0b69e9b', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    }  
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    } ?>
    </div>
</div><?php 
};
Parsed::$templates['components/helper_slot_default_61cc4f0b6a512'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>-x-<?php 
};
Parsed::$templates['slot_default_61cc4f0b6b5de'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['label',])));
     ?><label class="form-label"><?php echo htmlspecialchars($label); ?></label><?php 
};
Parsed::$templates['slot_default_61cc4f0b6ba40'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['value','placeholder','label',])));
     ?><input type="text" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php 
};
Parsed::$templates['slot_default_61cc4f0b6bd8f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['value','placeholder','label',])));
     ?><input type="number" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php 
};
Parsed::$templates['slot_default_61cc4f0b6c000'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['value','placeholder','label',])));
     ?><input type="email" class="form-control" value="<?php echo $value ;?>" placeholder="<?php echo $placeholder ?? $label ;?>"><?php 
};
Parsed::$templates['slot_default_61cc4f0b6c25f'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['name','values','label',])));
     ?><label>
            <input type="checkbox" value="1" <?php echo (in_array($name, $values) ? 'checked' : ''); ?>>
            <?php echo htmlspecialchars($label); ?>
        </label><?php 
};
Parsed::$templates['slot_default_61cc4f0b6c5e0'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['name','val','value','label',])));
     ?><label>
            <input type="radio" name="<?php echo $name ;?>" <?php echo ($val == $value ? 'checked' : ''); ?> value="<?php echo $val ;?>">
            <?php echo htmlspecialchars($label); ?>
        </label><?php 
};
Parsed::$templates['slot_default_61cc4f0b6c8cc'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['options','val','label','value',])));
     ?><select class="form-control">
            <?php foreach ($options as $val => $label) { ?><option value="<?php echo $val ;?>" <?php echo ($val == $value ? 'checked' : ''); ?>><?php echo htmlspecialchars($label); ?></option><?php } ?>
        </select><?php 
};
Parsed::$templates['slot_default_61cc4f0b6cc84'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['placeholder','label','_attrs','k','v','value',])));
     ?><textarea class="form-control" placeholder="<?php echo $placeholder ?? $label ;?>" <?php foreach($_attrs as $k=>$v) echo "$k=\"$v\" "; ?>><?php echo htmlspecialchars($value); ?></textarea><?php 
};
Parsed::$templates['components/form-group'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['class','slots','slot','data','comp','type','error',])));
     ?><div class="form-group <?php echo !empty($class) ? $class : '' ;?>">
    <?php 
    if (!empty($slots["label"])) {
    foreach ($slots['label'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc4f0b6b5de', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    }  
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $slot->render(array_merge($data, ['type' => $type]));
    }
    }
    else  {
    $comp = Parsed::template('slot_default_61cc4f0b6ba40', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    $comp = Parsed::template('slot_default_61cc4f0b6bd8f', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    $comp = Parsed::template('slot_default_61cc4f0b6c000', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    $comp = Parsed::template('slot_default_61cc4f0b6c25f', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    $comp = Parsed::template('slot_default_61cc4f0b6c5e0', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    $comp = Parsed::template('slot_default_61cc4f0b6c8cc', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    $comp = Parsed::template('slot_default_61cc4f0b6cc84', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    }  if (!empty($error)) { ?><span class="error"><?php echo htmlspecialchars($error); ?></span><?php } ?>
</div><?php 
};
Parsed::$templates['components/card_slot_default_61cc4f0b6a831'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','entry_firstname','firstname','data','entry_lastname','lastname',])));
     ?><div class="row">
        <?php $comp0 = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_firstname, 'value' => $firstname]);

    $comp0->render($data);  $comp0 = Parsed::template('components/form-group', ['type' => 'text', 'class' => 'col-6', 'name' => 'firstname', 'label' => $entry_lastname, 'value' => $lastname]);

    $comp0->render($data); ?>
    </div><?php 
};
Parsed::$templates['components/helper_slot_default_61cc4f0b6d822'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?>Helper<?php 
};
Parsed::$templates['components/card_slot_label_61cc4f0b6d7ad'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><label><?php $comp0 = Parsed::template('components/helper', []);
$comp1 = $comp0->addSlot('default', Parsed::template('components/helper_slot_default_61cc4f0b6d822', []));

    $comp1->setSlots($slots);
    $comp0->render($data); ?> Label with helper</label><?php 
};
Parsed::$templates['extra-fields?id=61cc4f0b6e3c9'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['blocks','slots','slot','a','b','i1','i2','block','data',])));
     ?><?php 
    $blocks = [];
    $blocks[] = Parsed::template('components/form-group', [])->setSlots($slots)->setIndex(0);
    if (isset($slots['extra-fields'])) {
    foreach ($slots['extra-fields'] as $slot) {
    $blocks[] = $slot;
    }
    }
    usort($blocks, function($a, $b) {
            $i1 = isset($a->data["_index"]) ? $a->data["_index"] : 0;
            $i2 = isset($b->data["_index"]) ? $b->data["_index"] : 0;
            return $i1 - $i2;
        });
    foreach ($blocks as $block) {
    $block->render($data);
    } ?><?php 
};
Parsed::$templates['user-profile-form'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['slots','slot','data','comp0','comp1','comp','entry_email','email','entry_male','entry_female','entry_gender','gender','comp2',])));
     ?><extends template="layouts/app"></extends><?php 
    if (!empty($slots["ascomp"])) {
    foreach ($slots['ascomp'] as $slot) {
    $slot->render(array_merge($data, []));
    }
    }
    else  {$comp0 = Parsed::template('components/helper', []);
$comp1 = $comp0->addSlot('default', Parsed::template('components/helper_slot_default_61cc4f0b6951f', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    $comp = Parsed::template('slot_default_61cc4f0b696d2', $data);
    $comp->setSlots($slots);
    $comp->render($data);
    }  $comp0 = Parsed::template('components/card', []);

    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $comp0->addSlot('title', $slot);
    }
    }
    if (!empty($slots["default"])) {
    foreach ($slots['default'] as $slot) {
    $comp0->addSlot('title', $slot);
    }
    }
    else  {$comp0 = Parsed::template('components/helper', []);
$comp1 = $comp0->addSlot('default', Parsed::template('components/helper_slot_default_61cc4f0b6a512', []));

    $comp1->setSlots($slots);
    $comp0->render($data);
    }$comp1 = $comp0->addSlot('default', Parsed::template('components/card_slot_default_61cc4f0b6a831', ['class' => 'row']));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'email', 'name' => 'email', 'label' => $entry_email, 'value' => $email]));
$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'select', 'options' => ['male' => $entry_male, 'female' => $entry_female], 'name' => 'gender', 'label' => $entry_gender, 'value' => $gender]));
$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'checkbox', 'options' => ['o1' => 'A', 'o2' => 'B'], 'name' => 'options', 'label' => 'Options', 'values' => ['o1']]));
$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'radio', 'options' => ['1' => 'A', '2' => 'B'], 'name' => 'radio', 'label' => 'Radio', 'value' => '2']));
$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'textarea', 'rows' => '10', 'name' => 'textarea', 'label' => 'Label', 'value' => 'some text']));
$comp2 = $comp1->addSlot('label', Parsed::template('components/card_slot_label_61cc4f0b6d7ad', []));

    $comp2->setSlots($slots);
    $comp0->render($data); ?><?php 
};
Parsed::$templates['user-profile-form_slot_mytitle_61cc4f0b6f43b'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, [])));
     ?><div>mytitle</div><?php 
};
Parsed::$templates['test'] = function ($data, $slots) {
    extract($data); $_attrs = array_intersect_key($data, array_flip(array_diff($_attrs, ['comp0','comp1','slots','data',])));
     ?><!DOCTYPE html>
<html>
    <head>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    </head>
    
    <body>
        <?php $comp0 = Parsed::template('user-profile-form', []);
$comp1 = $comp0->addSlot('mytitle', Parsed::template('user-profile-form_slot_mytitle_61cc4f0b6f43b', []));

    $comp1->setSlots($slots);$comp1 = $comp0->addSlot('default', Parsed::template('components/form-group', ['type' => 'text', 'class' => 'extra-fields', 'name' => 'firstname', 'label' => 'ef2', 'value' => 'ef2']));

    $comp0->render($data); ?>
    </body>
</html><?php 
};
new DomEvent('rendering', 'user-profile-form', function($template, $data) {
            $comp = Parsed::template('layouts/app');
            $comp->addSlot('default', $template);
            $comp->render($data);
            return false;
        });
Parsed::template('test', $data)->render(); ?>
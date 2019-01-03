Stenik\CustomVarAccessor module provides the ability to access custom var from every phtml template.

To fetch custom variable in template use:
```php
<? $block->getVar($varCode, 'customVarName'); ?>
```
to fetch custom variable's name or
```php
<? $block->getVar($varCode, 'customVarText'); ?>
```
to fetch custom variable's plain value or
```php
<? $block->getVar($varCode, 'customVarHtml'); ?>
```
to fetch custom variable's html value <br>
where $vatCode is the custom var's code
<?php

namespace Stenik\CustomVarAccessor\Plugin;

use Magento\Variable\Model\Variable;
use Magento\Framework\View\Element\AbstractBlock;

/**
 * Class AbstractBlockPlugin
 * @package Stenik\ModuleCustomVarAccessor\Plugin
 * @author Stenik Team <office@stenik.bg>
 */
class AbstractBlockPlugin
{

    /**
     * @var Variable
     */
    protected $variable;

    /**
     * AbstractBlockPlugin constructor
     * @param Variable $variable
     */
    public function __construct(Variable $variable)
    {
        $this->variable = $variable;
    }

    /**
     * @param AbstractBlock $abstractBlock
     * @param callable $proceed
     * @param $name
     * @param null $module
     * @return string|false
     */
    public function aroundGetVar(AbstractBlock $abstractBlock, callable $proceed, $name, $module = null)
    {
        if ($module == 'customVarHtml')
            return $this->variable->loadByCode($name)->getHtmlValue();

        if ($module == 'customVarText')
            return $this->variable->loadByCode($name)->getPlainValue();

        if ($module == 'customVarName')
            return $this->variable->loadByCode($name)->getName();

        return $proceed($name, $module);

    }


}

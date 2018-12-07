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
     * @param $code
     * @param null $module
     * @return string|false
     */
    public function aroundGetVar(AbstractBlock $abstractBlock, callable $proceed, $code, $module = null)
    {
        if ($module == 'customVarHtml' && $this->getCustomVarByCode($code))
            return $this->variable->getHtmlValue();

        if ($module == 'customVarText' && $this->getCustomVarByCode($code))
            return $this->variable->getPlainValue();

        if ($module == 'customVarName' && $this->getCustomVarByCode($code))
            return $this->variable->getName();

        return $proceed($code, $module);

    }

    /**
     * @param $code
     * @return boolean
     */
    protected function getCustomVarByCode($code)
    {
        if ($result = $this->variable->getResource()->getVariableByCode($code, true, $this->variable->getStoreId())) {
            $this->variable->setData($result);
            return true;
        }
        return false;
    }


}

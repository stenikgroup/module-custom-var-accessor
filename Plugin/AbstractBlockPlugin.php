<?php

namespace Stenik\CustomVarAccessor\Plugin;

use Magento\Store\Model\StoreManagerInterface;
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
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * AbstractBlockPlugin constructor
     * @param Variable $variable
     */
    public function __construct(Variable $variable, StoreManagerInterface $storeManager)
    {
        $this->variable     = $variable;
        $this->storeManager = $storeManager;
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
        if ($module == 'customVarHtml' && $this->getCustomVarByCode($code)) {
            if ($this->variable->getStoreHtmlValue()) {
                return $this->variable->getStoreHtmlValue();
            }
            return $this->variable->getHtmlValue();
        }

        if ($module == 'customVarText' && $this->getCustomVarByCode($code)) {
            if ($this->variable->getStorePlainValue()) {
                return $this->variable->getStorePlainValue();
            }
            return $this->variable->getPlainValue();
        }

        if ($module == 'customVarName' && $this->getCustomVarByCode($code)) {
            return $this->variable->getName();
        }

        return $proceed($code, $module);

    }

    /**
     * @param $code
     * @return boolean
     */
    protected function getCustomVarByCode($code)
    {
        if ($result = $this->variable->getResource()->getVariableByCode($code, true, $this->getStoreId())) {
            $this->variable->setData($result);
            return true;
        }
        return false;
    }

    /**
     * Get store identifier
     *
     * @return  int
     */
    protected function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

}

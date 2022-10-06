<?php
/**
 * MethodAvailable class
 *
 * @package I95Dev\CustomPayment
 */

namespace I95Dev\DisablePaymentMethods\Plugin\Model\Method;

class MethodAvailable
{
    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param Magento\Payment\Model\MethodList $subject
     * @param $result
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetAvailableMethods(\Magento\Payment\Model\MethodList $subject, $result): array
    {
        foreach ($result as $key => $_result) {
            $paymentId = $_result->getCode();
            $configuredIds = $this->scopeConfig->getValue('disablepaymentmethods/general/hide_payment_methods_id', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            if (null !== $configuredIds)
                $paymentIds = explode(",", $configuredIds);
            if (!empty($paymentIds)) {
                if (in_array($paymentId, $paymentIds)) {
                    unset($result[$key]);
                }
            }
        }
            return $result;
            }
}

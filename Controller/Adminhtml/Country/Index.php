<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-11 21:02:32
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-13 16:00:34
 */

namespace Beecom\Region\Controller\Adminhtml\Country;

class Index extends \Beecom\Region\Controller\Adminhtml\Country
{
    /**
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            'Countrys Manager',
            'Countrys Manager'
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Customers'));
        $resultPage->getConfig()->getTitle()
            ->prepend('Countrys Manager');
        return $resultPage;
    }
}

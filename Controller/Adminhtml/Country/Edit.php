<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2016-12-12 22:29:31
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2016-12-13 15:12:07
 */

namespace Beecom\Region\Controller\Adminhtml\Country;

use Magento\Backend\App\Action;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Beecom_Country::region_edit';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magento_Customer::customer');
        return $resultPage;
    }

    /**
     * Edit Country page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // Get ID and create model
        $id = (int) $this->getRequest()->getParam('region_id');
        $model = $this->_objectManager->create('Beecom\Region\Model\Country');
        $model->setData([]);
        // Initial checking
        if ($id && $id > 0) {
            $model->load($id);
            if (!$model->getCountryId()) {
                $this->messageManager->addError(__('This region no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
            $default_name = $model->getDefaultName();
        }

        $FormData = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($FormData)) {
            $model->setData($FormData);
        }

        $this->_coreRegistry->register('beecom_region', $model);

        $countryHelper = $this->_objectManager->get('Magento\Directory\Model\Config\Source\Country');

        $this->_coreRegistry->register('beecom_region_country_list', $countryHelper->toOptionArray());

        // Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Country') : __('New Country'),
            $id ? __('Edit Country') : __('New Country')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Countrys Manager'));
        $resultPage->getConfig()->getTitle()
            ->prepend($id ? 'Edit: '.$default_name.' ('.$id.')' : __('New Country'));

        return $resultPage;
    }
}

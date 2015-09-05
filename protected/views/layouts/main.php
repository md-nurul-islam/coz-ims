<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>

        <div class="container" id="page">

            <div id="header">
                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
                <?php if (!Yii::app()->user->isGuest && !Yii::app()->user->isSuperAdmin) { ?>
                <div class="store-info"><?php echo CHtml::encode(Yii::app()->user->storeName); ?></div>
                <div class="store-info-address"><?php echo CHtml::encode(Yii::app()->user->storeAddress); ?></div>
                <?php } ?>
            </div><!-- header -->
            
            <div class="clearfix"></div>
            
            <div id="mainmenu">
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array('label' => 'Store', 'url' => array('/store/manage/update'), 'visible' => !Yii::app()->user->isGuest && (Yii::app()->user->isSuperAdmin || Yii::app()->user->isStoreAdmin) ),
                        array('label' => 'Supplier', 'url' => array('/supplier/manage'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Customer', 'url' => array('/customer/manage'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Product', 'url' => array('/product/manage'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Purchase', 'url' => array('/product/purchase'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Sales', 'url' => array('/product/sale'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Exchange', 'url' => array('/product/exchange'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Reports', 'url' => array('/reports/sale'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Change Password', 'url' => array('/user/default/changePassword'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
                    ),
                ));
                ?>
            </div><!-- mainmenu -->
            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
<?php endif ?>

<?php echo $content; ?>

            <div class="clear"></div>

            <div id="footer">
                Copyright &copy; <?php echo date('Y'); ?> COZ-IMS<br/>
                All Rights Reserved.<br/>
                Powered by <a rel="external" href="http://www.codeonezero.com/">Code One Zero</a>
<?php //echo Yii::powered();  ?>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>

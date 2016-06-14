<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\web\Session;
/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
	
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Template Generator',
                'brandUrl' => ['/users'],
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/users']],
					['label' => 'Defined Templates', 'url' => ['/users/defined']],
					['label' => 'Create Template', 'url' => ['/users/custom']],
					  Yii::$app->user->isGuest ?
                         ['label' => 'Editor', 'url' => ['/users/viewcustom']]:
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/users/logout'],
                            'linkOptions' => ['data-method' => 'post']],
					['label' => 'Signup', 'url' => ['/users/signup']],
					 
					
					
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

  

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

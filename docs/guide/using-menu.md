Using Menu
==========

Menu manager used for build hierarchical menu. This is automatically look of user 
role and permision then return menus that he has access.

```php
use jackh\admin\components\MenuHelper;
use yii\bootstrap\Nav;

echo Nav::widget([
    'items' => MenuHelper::getAssignedMenu(Yii::$app->user->id)
]);
```

Return of `jackh\admin\components\MenuHelper::getAssignedMenu()` has default format like:

```php
[
    [
        'label' => $menu['name'], 
        'url' => [$menu['route']],
        'items' => [
			[
				'label' => $menu['name'], 
				'url' => [$menu['route']]
            ],
            ....
        ]
    ],
    [
        'label' => $menu['name'], 
        'url' => [$menu['route']],
        'items' => [
			[
				'label' => $menu['name'], 
				'url' => [$menu['route']]
            ]
        ]
    ],
    ....
]
```

where `$menu` variable correspond with a record of table `menu`. You can customize 
return format of `jackh\admin\components\MenuHelper::getAssignedMenu()` by provide a callback to this method.
The callback must have format `function($menu){}`. E.g:

You can add html options attribute to Your menu, for example "title". When You create a menu, in field data (textarea) fill this :
``` return ['title'=>'Title of Your Link Here']; ```

and then in Your view:

```php
$callback = function($menu){
    $data = eval($menu['data']);
    return [
        'label' => $menu['name'], 
        'url' => [$menu['route']],
        'options' => $data,
        'items' => $menu['children']
    ];
}

$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);
```

Default result is get from `cache`. If you want to force regenerate, provide boolean `true` as forth parameter.

You can modify callback function for advanced usage.

Using Sparated Menu
-------------------
Second parameter of `jackh\admin\components\MenuHelper::getAssignedMenu()` used to get menu on it's own hierarchy.
E.g. Your menu structure:

* Side Menu
  * Menu 1
    * Menu 1.1
    * Menu 1.2
    * Menu 1.3
  * Menu 2
    * Menu 2.1
    * Menu 2.2
    * Menu 2.3
* Top Menu
  * Top Menu 1
    * Top Menu 1.1
    * Top Menu 1.2
    * Top Menu 1.3
  * Top Menu 2
  * Top Menu 3
  * Top Menu 4

You can get 'Side Menu' chldren by calling

```php
$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, $sideMenuId);
```

It will result in
* Menu 1
  * Menu 1.1
  * Menu 1.2
  * Menu 1.3
* Menu 2
  * Menu 2.1
  * Menu 2.2
  * Menu 2.3

Filtering Menu
--------------
If you have `NavBar` menu items and want to filtering according user login. You can use Helper class
```php
<?php
user jackh\admin\components\Helper;

$menuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
    ['label' => 'About', 'url' => ['/site/about']],
    ['label' => 'Contact', 'url' => ['/site/contact']],
    ['label' => 'Login', 'url' => ['/user/login']],
    [
        'label' => 'Logout (' . \Yii::$app->user->identity->username . ')',
        'url' => ['/user/logout'],
        'linkOptions' => ['data-method' => 'post']
    ],
    ['label' => 'App', 'items' => [
        ['label' => 'New Sales', 'url' => ['/sales/pos']],
        ['label' => 'New Purchase', 'url' => ['/purchase/create']],
        ['label' => 'GR', 'url' => ['/movement/create', 'type' => 'receive']],
        ['label' => 'GI', 'url' => ['/movement/create', 'type' => 'issue']],
    ]]
];

$menuItems = Helper::filter($menuItems);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
``` 
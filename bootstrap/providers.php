<?php

return [
    App\Auth\AuthServiceProvider::class,
    App\Providers\AppServiceProvider::class,
    App\Size\SizeServiceProvider::class,
    App\User\UserServiceProvider::class,
    App\Category\CategoryServiceProvider::class,
    App\Cart\CartServiceProvider::class,
    App\CartDetail\CartDetailServiceProvider::class,
    App\Product\ProductServiceProvider::class,
    App\Attribute\AttributeServiceProvider::class,
    App\AttributeValue\AttributeValueServiceProvider::class,
];

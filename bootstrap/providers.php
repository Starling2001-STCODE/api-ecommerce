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
    App\AttrCategory\AttrCategoryServiceProvider::class,
    App\ProductVariant\ProductVariantServiceProvider::class,
    App\VariantAttributeValue\VariantAttributeValueServiceProvider::class,
    App\ProductImage\ProductImageServiceProvider::class,
    App\VariantImage\VariantImageServiceProvider::class,
    App\AttributeValueImage\AttributeValueImageServiceProvider::class,
    App\Inventory\InventoryServiceProvider::class,
    \App\InventoryTransaction\InventoryTransactionServiceProvider::class,
    \App\ShippingAddress\ShippingAddressServiceProvider::class,
    App\Order\OrderServiceProvider::class,
];

<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('მთავარი', route('home'));
});

// Home > About
Breadcrumbs::for('about', function ($trail) {
    $trail->parent('home');
    $trail->push('About', route('about'));
});

// Home > Blog
Breadcrumbs::for('shop', function ($trail) {
    $trail->parent('home');
    $trail->push('მაღაზია', route('shop'));
});

// Home > Blog > [Category]

Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('shop');
    $trail->push($category->category_name, route('shop.wfilter'));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});


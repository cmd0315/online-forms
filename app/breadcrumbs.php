<?php

Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->push('Dashboard', route('dashboard'));
});

Breadcrumbs::register('my-profile', function($breadcrumbs) {
    $breadcrumbs->push('My Profile', route('profile.index'));
});

Breadcrumbs::register('change-password', function($breadcrumbs) {
    $breadcrumbs->parent('my-profile');
    $breadcrumbs->push('Change Password', route('accounts.edit'));
});
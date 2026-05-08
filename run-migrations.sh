#!/bin/bash
php artisan migrate --force
php artisan optimize

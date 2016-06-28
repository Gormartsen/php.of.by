#!/bin/sh

cd $ZENCI_DEPLOY_DIR
php phing.phar build-ci

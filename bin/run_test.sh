#!/bin/sh

cd $DEPLOY_DIR
php phing.phar build-ci

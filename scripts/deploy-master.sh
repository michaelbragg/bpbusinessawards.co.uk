#!/bin/sh
#
# Deploy to production server

# Run tests and build script

# Install dependencies
echo "Install dependencies"
composer install --no-dev --no-interaction

# Build theme
cd ./html/app/themes/bpba/
bower install
grunt dev
cd ~/clone
#grunt build

# Set timestamp
echo "Set Time Stamp"
TIMESTAMP=$(date +%Y%m%d%H%M%S)

# Make a new releases folder
echo "Make new release folder"
ssh $USERNAME@$HOST "mkdir $DEPLOY_TO/releases/$TIMESTAMP"

# Copy files
echo "Copy files to server"
rsync -avz -e "ssh" --exclude="/app/themes/bpba/node_modules" --exclude="/media/" --exclude="/app/languages" ./html $USERNAME@$HOST:$DEPLOY_TO/releases/$TIMESTAMP

# Symlink shared folders
echo "Symlink shared folders"
ssh $USERNAME@$HOST "ln -s $SHARED/media $DEPLOY_TO/releases/$TIMESTAMP/media"
ssh $USERNAME@$HOST "ln -s $SHARED/languages $DEPLOY_TO/releases/$TIMESTAMP/app/languages"

## Symlink previous events
echo "Symlink previous events"
ssh $USERNAME@$HOST "ln -s $DEPLOY_TO/archive/2011 $DEPLOY_TO/releases/$TIMESTAMP/2011"
ssh $USERNAME@$HOST "ln -s $DEPLOY_TO/archive/2012 $DEPLOY_TO/releases/$TIMESTAMP/2012"
ssh $USERNAME@$HOST "ln -s $DEPLOY_TO/archive/2013 $DEPLOY_TO/releases/$TIMESTAMP/2013"
ssh $USERNAME@$HOST "ln -s $DEPLOY_TO/archive/2014 $DEPLOY_TO/releases/$TIMESTAMP/2014"
ssh $USERNAME@$HOST "ln -s $DEPLOY_TO/archive/2015 $DEPLOY_TO/releases/$TIMESTAMP/2015"

# Update app version
echo "Update app version"
ssh $USERNAME@$HOST "rm -rf $CURRENT;ln -s $DEPLOY_TO/releases/$TIMESTAMP/ $CURRENT"

# Remove previous releases
echo "Remove previous releases (@TODO)"
ssh $USERNAME@$HOST "ls -t $DEPLOY_TO/releases | tail -n +6"
#ssh $USERNAME@$HOST "cd $DEPLOY_TO/releases;rm -rf `ls -t | tail -n +6`;ls -l"

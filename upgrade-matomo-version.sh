#!/bin/sh

set -eu

NEW_MATOMO_VERSION=$1

git reset --hard HEAD
git pull

echo -n "-----> Editing & pushing Matomo version file..."
echo "$NEW_MATOMO_VERSION" > ./bin/version
git add ./bin/version
git commit -m "Upgrade version to $NEW_MATOMO_VERSION"
git push
echo "done"

echo -n "-----> Releasing and publishing a new tag..."
git fetch --all --tags
git tag -a "v$NEW_MATOMO_VERSION" -m "Release v$NEW_MATOMO_VERSION"
git push --tag
echo "done"

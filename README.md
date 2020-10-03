# Matomo-buildpack

## Upgrading

```shell script
./upgrade-matomo-version <new_matomo_version> #ex: 3.14.1
```

## Rebuild an already published version

```shell script
# some changes and git operations
git tag -d v3.14.1 && \
  git push --delete origin v3.14.1 && \
  git tag -a "v3.14.1" -m "Release v3.14.1" && \
  git push --tag
```

## Links

- Inspired by [Metabase-buildpack](https://github.com/metabase/metabase-buildpack)
- [Buildpacks - Buildpack Interface Specification](https://github.com/buildpacks/spec/blob/main/buildpack.md).
- [Scalingo - Use a Custom Buildpack](https://doc.scalingo.com/platform/deployment/buildpacks/custom)

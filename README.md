# release-notes



## Installing
When installing to your site, add the following to you `composer.json` file. This will ensure that installation will use the build version of the package and allow it to be loaded using composer in the preferred path.
```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:bigbite/release-notes.git"
    }
  ],
  "require": {
    "bigbite/release-notes": "1.0.0-rc.6"
  },
  "extra": {
    "installer-paths": {
      "mu-plugins/{$name}/": [
        "type:wordpress-muplugin"
      ]
    }
  }
}

```

## Local Development or Manual Install
Clone the repository into your `plugins` or `client-mu-plugins` directory.
```
git clone git@github.com:bigbite/release-notes.git && cd release-notes
```

Install JS packages.
```
npm install
```

Build all assets - additional commands can be found on the [`bigbite/build-tools` repo.](https://github.com/bigbite/build-tools#commands)
```
npm run build:dev
```

Install PHP packages and create autoloader for the plugin.
```
composer update
```

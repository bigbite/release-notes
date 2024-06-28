# release-notes

## Slack integration setup
1. Create a slack app & webhook if you don't have one already (Follow steps 1 to 3 at https://api.slack.com/messaging/webhooks)
2. Add the webhook to the sites settings page (wp-admin -> settings -> Release Notes)

## Integrating with github releases
If you want to create a draft release note post using the notes you've added to the github release, you can do this automatically using the `bigbite/project` circleCI orb version `0.0.63` or newer. You just need to add the following to your .circleci/config.yml` file:
```yaml
workflows:
  release-workflow:
    jobs:
      - project/set-release-notes:
          context: bigbite
          filters:
            branches:
              ignore: /.*/
            tags:
              only: /^[0-9]+\.[0-9]+\.[0-9]+(\-[\w\d\.]+)?$/
```

## Creating a draft release remotely
If you want to create a draft release remotely, you can use the REST endpoint `POST /release-notes/v1/new-release` with the following parameters:
- body: string - a git-markdown string used for the content of the release note post
- isDraft: boolean - used to check if the release is just a draft, if it is true, the release note post will not be created
- name: string - the name of the release
- publishedAt: UTC date-time string - used to set the release date of the release note post
- tagName: string - the release version
- isPrerelease: boolean - used to note if a release is a pre-release or not

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
      "plugins/{$name}/": [
        "type:wordpress-plugin"
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

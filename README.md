DoCA Site Theme
===============

The Department of Communications and Arts theme for the govCMS website

## Development

### Structure

* doca_base - `common` and `admin` themes
* doca_comms - `custom` theme for the site

### doca_base git subtree

`doca_base` is managed by `git subtree` and belong to another project [https://github.com/govCMS/doca_base].

Please try to avoid editing the files directly in this folder and commit your updates to the doca_base project instead.

#### If you know what you are doing in subtree

Update the `doca_base` to the latest version of repository, run this command in your theme

```
git subtree pull --prefix=doca_base --squash git@github.com:govCMS/doca_base.git 7.x-1.x
```

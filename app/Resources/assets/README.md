## [Assets management][1]

1. Install “[Yarn][2]” on your system.
2. Install all dependencies in “./node_modules” folder: `yarn install`.
3. To process assets:
    * once: `yarn encore dev`,
    * to *automatically process assets* when files change: `yarn encore dev --watch`.

**To create a production build:** `yarn encore production`.

> The warning message `The value passed to setPublicPath() should *usually* start with "/"…` appearing in console when launching preprocessing is due to the need of allowing development URLs starting from the Symfony project root and launching the “dev” bootstrap file (/web/app_dev.php).

[1]: https://symfony.com/doc/3.4/frontend.html
[2]: https://yarnpkg.com/lang/en/docs/install/


/*
 |--------------------------------------------------------------------------
 | Browser-sync config file
 |--------------------------------------------------------------------------
 |
 | For up-to-date information about the options:
 |   http://www.browsersync.io/docs/options/
 |
 | There are more options than you see here, these are just the ones that are
 | set internally. See the website for more info.
 |
 |
 */
require('dotenv').config();

module.exports = {
  "proxy": process.env.SITE_URL,
  "files": [
    "*.php",
    "*.css",
    "main.js"
  ],
  "watchEvents": [
    "change"
  ],
  "open": false
};

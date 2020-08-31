## Custom Wordpress Theme

Theme name: `starter`

## Development Setup

#### Theme starter

* Bootstrap v4.3.1 integrated
* using gulpifle.js for: `CSS` - `JS` - `browserSync` 

#### Setup Steps:

```bash
# First you have to install WP on your local machine
# after installing the WP, navigate to WP themes folder:
$ cd /opt/lampp/htdocs/starter/wp-content/themes
# and then clone repo(theme):
$ git clone https://github.com/ivanakruljac/starter.git
# navigate to `starter` folder:
$ cd cd /opt/lampp/htdocs/starter/wp-content/themes/starter
# and then:
$ npm install
```

#### Running the frontend environment:

```bash
# navigate to theme:
$ cd /opt/lampp/htdocs/starter/wp-content/themes/starter
# and then run the gulp tasks:
$ gulp tasks
# your browser will activate the proxy at http://localhost:2001/starter/
```

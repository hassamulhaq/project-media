### How to setup


___
___

#### Host on live domain
set `const PROJECT_NAME` is to `null` in autoload_files.php if you host project on live server (domain)
e.g
```
const PROJECT_NAME = null;
```

___

#### Run locally like localhost then
don't remove `const PROJECT_NAME` in autoload_files.php if you run project locally using Xampp etc.

Only replace value of `const PROJECT_NAME = 'project directory name'`
e.g
```
const PROJECT_NAME = 'myproject';
const PROJECT_NAME = 'project';
const PROJECT_NAME = 'etc';
```
___
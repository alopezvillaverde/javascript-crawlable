javascript-crawlable
====================

There is a known problem regarding to JavaScript and search engine crawlers. Search engines as Google don't read JavaScript code. So if you want to use a MVC JavaScript framework such as BackboneJS or AngularJS for your developments, you have a problem. Your data is hidden in templates so this isn't good for SEO. The solution stops by PhantomJS with a little bit of coding.


## How it works

The first thing we have to do is configure our .htaccess apache configuration file properly. All the non-existent requests will be redirected to our phantom.php file with the url itself as a parameter.

Setting a number of tries we execute PhantomJS via shell with a timeout to render our JavaScript code as HTML code. In addition, we use a tiny system cache for getting better performance results.

# cyve/url
URL manipulation

## Installation
```bash
$ composer require cyve/url
```

## Usage
```php
use Cyve\Url\Url;

$url = new Url('https://user:pwd@www.domain.tld:8080/foo/bar?key=value#hash');

echo $url->scheme; // https
echo $url->username; // user
echo $url->password; // pwd
echo $url->host; // www.domain.tld
echo $url->subDomain; // www
echo $url->domain; // domain.tld
echo $url->tld; // tld
echo $url->port; // 8080
echo $url->path; // /foo/bar
echo $url->path[0]; // foo
echo $url->path[1]; // bar
echo $url->query; // key=value
echo $url->query->get('key'); // value
echo $url->query->get('undefined', 'default'); // default
echo $url->fragment; // hash
```

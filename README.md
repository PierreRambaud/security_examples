# PrestaShop Security Module 

## About

Module to helps you to understand what kinds of security issues exist and how you can prevent it.

## Requirements

A working Prestashop 1.7.5 instance and composer (only for development).

## Understanding exploits

### RCE (Remote Code Execution)

Never execute something you can't control. Prefer whitelist as much as possible, or escape string.
For example, if you're using `Symfony\Component\Process\Process`, use the default method to escape commands:

```php
$process = new Process(
    [
        $this->getParameter('kernel.root_dir') . '/../bin/console',
        'debug:' . $type // This one will be automatically escaped
    ]
);
$process->run();
```

or `escapeshellargs`

```php
$process = exec(
    __PS_ROOT_DIR__ . '/bin/console ' . 
    escapeshellargs('debug:' . $type)
);
```

### Xss (Cross Site Scripting)

If you don't care about this, you're completly wrong!
A thief can take screenshot of your browser, retrieve all form data, control your webcam, get your cookies, ... 
And if you're using a CMS, with a little piece of code, can create and admin account without being notify.
Get a look at (https://beefproject.com/)[https://beefproject.com/], you'll be surprise.

So, don't be shy, always sanitize data and do not display it directly, use `htmlentities`, `htmlspecialchars`, ...

### SQL Injection

Like others, never trust something you don't control.
With a simple script, an attacker can retrieve or create many thing into your database.
Or even try to bruteforce your database password.
```python
found_chars = ''
for i in range(20):
    for c in characters:
        try:
            blind_sql = '?username='+username+'" AND IF(password like BINARY "' + found_chars + c + '%",sleep('+sleepTime+'),null)"'
            r = requests.get(target + blind_sql, timeout=5)
        except requests.exceptions.Timeout:
            found_chars += c
            print 'Found chars in password: ' + found_chars
            break
```

Watch out with rights you give to your database user.

## LFI (Local File Include)

Same as previous, use whitelist, identifier to request a file instead of it's real name.
Prefer `http://website.com/download/files/2934` or `http://website.com/download/files/my-file` than `http://website.com/download?file=csv/my-file.csv`.



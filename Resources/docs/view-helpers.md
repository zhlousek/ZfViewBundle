#View Helpers

Just like Twig functions, view helpers provide you various functionalities available within your templates. For example, the `path` view helper is a direct equivalent to the `path` Twig function which is used to generate paths:

```php
    <a href="<?php echo $this->path('contact_us', array('lang' => 'en')) ?>">Contact Us</a>
```

##Built-in view helpers

###Routing helpers

```php
<?php
  
  //Generate paths
  echo $this->path('route_name', $parameters = array('param1' => 'value1'), $relative = false);
  
  //Generate URLs
  echo $this->url('route_name', $parameters = array('param2' => 2), $relative = false);

```

The above helpers work exactly like their Twig counterparts, `{{ path(...) }}` and `{{ url(...) }}`.

###SecurityContext helpers

```php
<?php
    
    //Retrieve authenticated user. Returns null if authentication is absent in security context.
    $currentUser = $this->security()->user();
    
    // Query authorization layer.
    if ($this->security()->isGranted('ROLE_ADMIN', $object, $field = 1)) {
        /* AUTHORIZED! */
    }
```

###Translation helpers
```php
    
    //Straight-forward string translation. Only first argument -- the string key -- is required.
    
    echo $this->trans('message.to.translate', $arguments = array(), $domain = 'FooBundle', $locale = 'fr_FR');
    
    //Translation with pluralization. Only first and second argument -- the string key and count -- are required.
    echo $this->trans()
              ->choice(
                    '{0} There is no apples|{1} There is one apple|]1,Inf[ There are %count% apples',
                    $count = 10,
                    $arguments = array(),
                    $domain = 'messages',
                    $locale = 'en_US',
              );
    
```

##Writing your own view helper...

Simply extend `Zend\View\Helper\AbstractHelper` or implement `Zend\View\Helper\HelperInterface`, define it as a service tagged with `zend.view_helper`.

Example:

```yaml

services:
    foobundle.utils.mailto_formatter:
        class: FooBundle\Model\MailToFormatter
        tags:
            - { name: zend.view_helper, alias: mailTo }

```

Note the `alias` attribute. This is required. In the above example, you can invoke your view helper via this call:

```php
    echo $this->mailTo("bezalelhermoso@gmail.com", array('subject' => 'Hello!'));
```

The parameters will be passed to the `__invoke` method of the view helper instance.
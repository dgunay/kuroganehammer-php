KuroganeHammer-PHP
=====================

A simple PHP library for the KuroganeHammer API. Developed for PHP 5.4 and up.

### About

The library is intended to follow the hierarchy found on [the official documentation website](http://api.kuroganehammer.com/swagger/ui/index), with each collection of functions having its own class and collection of associated methods, mirroring the API's list of endpoints almost 1:1. These objects are aggregated in the KuroganeHammer class. The result is that you can access

```api.kuroganehammer.com/api/characters/name/{name}``` 

in PHP like so:

```
$kh = new KuroganeHammer();
$marth = $kh->characters->character('Marth');
```

and the library takes care of the request for you.

### Lessons learned
I thought this would be easy at first but turns out designing an intuitive and efficient library actually takes some programming know-how. Something I severely lack. With that noted, you will find that this library lacks tests and probably a few other defensive coding principles. I expect it to have bugs.

Writing this library has been a learning experience in design patterns, as I quickly had to abandon a monolithic design architecture when the number of functions, and resulting cognitive overhead in trying to keep them sufficiently abstract, ballooned out of control. I also ran into my first legitimate use case for the Singleton pattern - sharing a cURL resource across multiple classes.

The library is currently a work in progress. Once finished I hope to add tests to it. The end goal is something useful and usable by anyone who needs this data and is working in PHP.


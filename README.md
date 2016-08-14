# The Sourcerer

The Sourcerer is a library to combine several sources for fetching resources in a centralized manner.

## Basic Usage

A repository is a special kind of source that contain a list of sources to delegate fetching of resources

```php
//Init a list of sources that implement Vacancy\Source
$sources = [$mysqlSource, $apiSource];

$repository = new Repository($sources);

//Use the repository to fetch a resource
$object = $repository->find(1);
```

## Restricting the sources to use

You can create a repository  configured with several sources but you can restrict the sources to use for a particular fetch

```php
//Have a repository with some registered sources
$repository = new Repository($sources);

//Use the repository to fetch a resource from a source called 'api'
$object = $repository->using('api')->find(1);
```

## Caching

```php
//Initialize a source with an implementation of a Vacancy\Cache\CacheProvider
$cacheSource = new CacheSource($redisCache, new ApiSource())
$sources = [$cacheSource];

$repository = new Repository($sources);

//Use the repository to fetch a resource
$object = $repository->find(1);
```




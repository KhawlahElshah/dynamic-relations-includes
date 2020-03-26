# Dynamic Relations Includes

This package allows you to include resources relationships and relationships count dynamically based on requests sent by sending query parameters with the request. This enables you to load relations only when you need them, which will boost your APIs performance.

----------


## Installation

This Package can be installed vie Composer 

```bash
composer require kalshah/dynamic-relations-includes
```


## Usage

### Include relations based on request

For Example we have an API request which returns a list of posts and we want to include the comments of each post within the response.  

To do this you first need to use the `IncludeRelations` trait on you `Post` model, and also you need to to add the `comments` relation on the `loadableRelations` array, so that the trait can load it for you.

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalshah\DynamicRelationsInclude\IncludeRelations;

class Post extends Model
{
    use IncludeRelations;

    protected $loadableRelations = ['comments'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
```

and now you can send your requests where you need the comments, by adding the `include` array parameter like so `www.example.com/posts?include[]=comments`

### Include relations count based on request

For Example we have an API with requests which returns a list of posts and we want to include the comments count of each post within the response.  

To do this you first need to use the `IncludeRelations` trait on you `Post` model, and also you need to to add the `comments` relation on the `loadableRelationsCount` array, so that the trait can load it for you.

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalshah\DynamicRelationsInclude\IncludeRelations;

class Post extends Model
{
    use IncludeRelations;

    protected $loadableRelationsCount = ['comments'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
```

and now you can send your requests where you need the comments count, by adding the `include_count` array parameter like so `www.example.com/posts?include_count[]=comments`


### Futher Explanations

- Both `loadableRelations` and `loadableRelationsCount` arrays must be set on models which you want to to load their relations.
- Both these array has been made to constrain which relations should be loaded, this to prevent dynamic loading of all relations which might hold sensitive data.

# Testing

You can run the tests using 

```bash
./vendor/bin/phpunit
```
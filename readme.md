# Dynamic Relations Includes

This package allows you to include resources relationships and relationships count dynamically based on requests sent by sending query parameters with the request. This enables you to load relations only when you need them, which will boost your APIs performance.

----------


## Installation

This Package can be installed vie Composer 

```bash
composer require kalshah/dynamic-relations-includes
```

For **Lumen** is same procedure but you need to add helper **request()**. Here is code: https://github.com/albertcht/lumen-helpers/blob/master/src/helpers.php#L417.


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

and now you can send your requests where you need the comments, by adding the `include` array parameter like so `www.example.com/posts?include=comments`

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

and now you can send your requests where you need the comments count, by adding the `include_count` array parameter like so `www.example.com/posts?include_count=comments`

&nbsp;

You can use both `include` and `include_count` parameters as string or as an array

- using it as a string with multiply includes `www.example.com/posts?include=comments,tags`

- using it as an array with multiply includes `www.example.com/posts?include[]=comments&include[]=tags`
  
### Using different relationships types and conventions
- you can include nested relationships, for example loading the comments and each comment       creator
  ```php
  protected $loadableRelations = ['comments', 'comments.creator'];
  ```
    and requesting it using `www.example.com/posts?include=comments.creator`

&nbsp;

- you can include and use camel cased relationships by adding it to the array like with its exact name

    ```php
    namespace App;

    use Illuminate\Database\Eloquent\Model;
    use Kalshah\DynamicRelationsInclude\IncludeRelations;

    class Profile extends Model
    {
        use IncludeRelations;

        protected $loadableRelationsCount = ['socialMediaAccounts'];

        public function socialMediaAccounts()
        {
            return $this->hasMany(socialMediaAccount::class);
        }
    }
    ```
    and then including it using either `www.example.com/profiles?include=social_media_accounts` or `www.example.com/profiles?include=socialMediaAccounts`


### Load all relationships
- If you want to load all relationships you can pass "**all**" to **include**:
  ```php
  ?include=all
  ```


### Futher Explanations

- Both `loadableRelations` and `loadableRelationsCount` arrays must be set on models which you want to to load their relations.
- Both these array has been made to constrain which relations should be loaded, this to prevent dynamic loading of all relations which might hold sensitive data.

# Testing

You can run the tests using 

```bash
./vendor/bin/phpunit
```

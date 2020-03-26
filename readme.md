# Dynamic Relations Includes

This package allows you to include resources relationships and relationships count dynamically based on requests sent by sending query parameters with the request. This enables you to load relations only when you need them, which will boost yo API performance.

----------


## Installation

This Package can be installed vie Composer 

```bash
composer require kalshah/dynamic-relations-includes
```


## Usage

### Include relations based on request

For Example we have an API with requests which returns a list of posts and we want to include the comments of each post within the response.  

To do this you first need to use the `IncludeRelations` trait on you `Post` model, and also you need to to add the `comments` relation on the `loadableRelations` array, so that the trait can load it for you.

`
how the post model will look like
`

and now when you send your requests where you need the comments, you can add it to `include` array parameter like so `www.example.com/posts?include[]=comments`

### Include relations count based on request

For Example we have an API with requests which returns a list of posts and we want to include the comments count of each post within the response.  

To do this you first need to use the `IncludeRelations` trait on you `Post` model, and also you need to to add the `comments` relation on the `loadableRelationsCount` array, so that the trait can load it for you.

`
how the post model will look like
`

and now when you send your requests where you need the comments count, you can add it to `include_count` array parameter like so `www.example.com/posts?include_count[]=comments`


### Futher Explanations

- Both `loadableRelations` and `loadableRelationsCount` array must be set on models you want to to load their relations.
- Both these array has been made to constrain which relations should be load, this to prevent dynamic loading of relation that hold sensitive data.
# Testing

You can run the tests using 

```bash
./vendor/bin/phpunit
```